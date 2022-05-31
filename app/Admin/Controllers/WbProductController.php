<?php


namespace App\Admin\Controllers;

use App\Models\Category;
use App\Models\Product;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class WbProductController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'WB Товары';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Product());
        $grid->model()->whereNotNull('wb_imtId');

        $grid->column('id', __('ID'))->sortable();
        $grid->column('name', __('Название'))->sortable();
        $grid->column('category_id', __('Категория'))->display(function($categoryId) {
            return Category::find($categoryId)->name;
        });
        $grid->column('article', __('Артикуль'));
        $grid->column('price2', __('Цена2'));
        $grid->column('price', __('WB цена'));
        $grid->column('quantity', __('Кол-во'));
        $grid->column('updated_at', __('Дата изменение'))->display(function ($updated_at) {
            return date('d.m.Y H:i', strtotime($updated_at));
        });

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed   $id
     * @return Show
     */
    protected function detail($id)
    {
        //$show = new Show(Product::findOrFail($id));
        $product = Product::with('thumb')->whereId($id)->first();
        $show = new Show($product);
        $product->thumb = $product->thumb[0]->path;
        $show->field('id', __('ID'));
        $show->field('article', __('Артикуль'));
        $show->field('name', __('Название'));
        $show->category_id('Категория')->as(function($categoryId){
            return Category::find($categoryId)->name;
        });
        $show->field('price1', __('Цена1'));
        $show->field('price2', __('Цена2'));
        $show->field('price', __('Ваша цена'));
        $show->field('quantity', __('Кол-во'));
        $show->thumb('Аватар')->image();
        $show->updated_at('Дата изменение')->as(function($updated_at){
            return date('d.m.Y H:i', strtotime($updated_at));
        });

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Product());

        $form->display('id', __('ID'));
        $form->display('price1', __('Цена1'));
        $form->display('price2', __('Цена2'));
        $form->number('price', __('Ваша цена'));

        return $form;
    }
}
