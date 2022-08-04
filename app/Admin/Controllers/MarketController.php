<?php

namespace App\Admin\Controllers;

use App\Models\MarketPlace;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class MarketController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'MarketPlace';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new MarketPlace());
        $grid->column('title', __('Название'));
        $grid->column('client_id', __('client_id'));
        $grid->column('client_secret', __('client_secret'));
        $grid->column('api', __('api'));


        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(MarketPlace::findOrFail($id));



        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new MarketPlace());

        $form->text('title', __('Название'));
        $form->text('api', __('API URL'));
        $form->text('client_id', __('client_id'));
        $form->text('client_secret', __('client_secret'));
        $form->display('access_token', __('access_token'));
        $form->display('refresh_token', __('refresh_token'));
        $form->display('token_type', __('token_type'));
        $form->display('expires_date', __('expires_date'));

        return $form;
    }
}
