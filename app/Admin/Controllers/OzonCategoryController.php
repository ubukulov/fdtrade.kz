<?php


namespace App\Admin\Controllers;

use App\Models\OZONCategory;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class OzonCategoryController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'OZON Категории';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new OZONCategory());
        $grid->model()->where('parent_id', '=', 0);

        $grid->column('id', __('ID'))->sortable();
        $grid->column('name', __('Название  '));
        $grid->column('updated_at', __('Дата изменение'))->display(function ($updated_at) {
            return date('d.m.Y H:i', strtotime($updated_at));
        });
        $grid->actions(function ($actions) {
            $actions->disableDelete();
            $actions->disableEdit();
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
        $oz_category = OZONCategory::findOrFail($id);
        $grid = new Grid(new OZONCategory());
        $grid->model()->where(['parent_id' => $oz_category->id]);
        $grid->column('id', __('ID'))->sortable();
        $grid->column('name', __('Название  '));
        $grid->actions(function ($actions) {
            $actions->disableDelete();
            $actions->disableEdit();
            $actions->disableView();
        });
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
        $form = new Form(new OZONCategory());

        $form->display('id', __('ID'));
        $form->display('created_at', __('Created At'));
        $form->display('updated_at', __('Updated At'));

        return $form;
    }
}
