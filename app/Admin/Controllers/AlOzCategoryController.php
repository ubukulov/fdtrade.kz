<?php


namespace App\Admin\Controllers;

use App\Models\AlOzCategory;
use App\Models\Category;
use App\Models\Product;
use App\Models\OZONCategory;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Illuminate\Support\Facades\DB;

class AlOzCategoryController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Соответствие категории Al-style и Ozon';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new AlOzCategory());

        $grid->column('al_category_id', __('Категория (Al-style)'))->display(function($categoryId) {
            return Category::find($categoryId)->name;
        });
        $grid->column('oz_category_id', __('Категория (OZON)'))->display(function($categoryId) {
            return OZONCategory::find($categoryId)->name;
        });

        $grid->column('id', __('Кол-во товаров'))->display(function($id) {
            $al_wb_category = AlOzCategory::findOrFail($id);
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
        $al_wb_category = AlOzCategory::findOrFail($id);
        $grid = new Grid(new Product());
        $grid->model()->with('category')->where('category_id', $al_wb_category->al_category_id)->where('price', '<>', 0);
        $grid->column('id', __('ID'))->sortable();
        $grid->column('name', __('Название'));
        $grid->column('quantity', __('Кол-во'));
        $grid->column('price2', __('Цена в AL'));
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
        $form = new Form(new AlOzCategory());

        $form->select('al_category_id', 'Выберите категория (Al-style)')->options(Category::all()->pluck('name', 'id'));
        $form->select('oz_category_id', 'Выберите категория (OZON)')->options(OZONCategory::all()->pluck('name', 'id'));

        return $form;
    }
}
