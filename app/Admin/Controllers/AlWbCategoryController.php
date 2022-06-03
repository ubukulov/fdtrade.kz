<?php


namespace App\Admin\Controllers;

use App\Models\AlWbCategory;
use App\Models\Category;
use App\Models\Product;
use App\Models\WBCategory;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Illuminate\Support\Facades\DB;

class AlWbCategoryController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'WB Категории';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new AlWbCategory());

        $grid->column('al_category_id', __('Категория (Al-style)'))->display(function($categoryId) {
            return Category::find($categoryId)->name;
        });
        $grid->column('wb_category_id', __('Категория (WB)'))->display(function($categoryId) {
            return WBCategory::find($categoryId)->name;
        });

        $grid->column('id', __('Кол-во товаров'))->display(function($id) {
            $al_wb_category = AlWbCategory::findOrFail($id);
            $categoryId = $al_wb_category->al_category_id;
            $result = DB::select("SELECT COUNT(*) as cnt FROM products WHERE category_id=$categoryId AND price <> 0");
            return (isset($result[0])) ? $result[0]->cnt : 0;
        });

        $grid->column('updated_at', __('Дата изменение'))->display(function ($updated_at) {
            return date('d.m.Y H:i', strtotime($updated_at));
        });

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed   $id
     * @return Grid
     */
    protected function detail($id)
    {
        $al_wb_category = AlWbCategory::findOrFail($id);
        $grid = new Grid(new Product());
        $grid->model()->with('category')->where('category_id', $al_wb_category->al_category_id)->where('price', '<>', 0);
        $grid->column('id', __('ID'))->sortable();
        $grid->column('name', __('Название'));
        $grid->column('quantity', __('Кол-во'));
        $grid->column('price1', __('Цена в AL'));
        $grid->column('price', __('Цена в WB'));
        $grid->column('margin', __('Маржа в %'))->display(function(){
            return $this->category->margin;
        });
        $grid->disableActions();
        $grid->column('updated_at', __('Дата изменение'))->display(function ($updated_at) {
            return date('d.m.Y H:i', strtotime($updated_at));
        });

        return $grid;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new AlWbCategory());

        $form->select('al_category_id', 'Выберите категория (Al-style)')->options(Category::all()->pluck('name', 'id'));
        $form->select('wb_category_id', 'Выберите категория (WB)')->options(WBCategory::all()->pluck('name', 'id'));

        return $form;
    }
}
