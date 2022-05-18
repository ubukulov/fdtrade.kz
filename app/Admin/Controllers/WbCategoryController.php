<?php


namespace App\Admin\Controllers;

use App\Models\WBCategory;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class WbCategoryController extends AdminController
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
        $grid = new Grid(new WBCategory());
        $grid->model()->whereNull('parent_id');

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
        $wb_category = WBCategory::findOrFail($id);
        $grid = new Grid(new WBCategory());
        $grid->model()->where(['parent_id' => $wb_category->foreign_id]);
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
        $form = new Form(new WBCategory());

        $form->display('id', __('ID'));
        $form->display('created_at', __('Created At'));
        $form->display('updated_at', __('Updated At'));

        return $form;
    }
}
