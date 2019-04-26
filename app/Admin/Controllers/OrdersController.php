<?php

namespace App\Admin\Controllers;

use App\Model\p_orders;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class OrdersController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('Index')
            ->description('description')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('Detail')
            ->description('description')
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('Edit')
            ->description('description')
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('Create')
            ->description('description')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new p_orders);

        $grid->oid('Oid');
        $grid->order_sn('Order sn');
        $grid->uid('Uid');
        $grid->order_amount('Order amount');
        $grid->pay_amount('Pay amount');
        $grid->add_time('Add time');
        $grid->pay_time('Pay time');
        $grid->status('Status');
        $grid->is_delete('Is delete');

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
        $show = new Show(p_orders::findOrFail($id));

        $show->oid('Oid');
        $show->order_sn('Order sn');
        $show->uid('Uid');
        $show->order_amount('Order amount');
        $show->pay_amount('Pay amount');
        $show->add_time('Add time');
        $show->pay_time('Pay time');
        $show->status('Status');
        $show->is_delete('Is delete');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new p_orders);

        $form->number('oid', 'Oid');
        $form->text('order_sn', 'Order sn');
        $form->number('uid', 'Uid');
        $form->number('order_amount', 'Order amount');
        $form->number('pay_amount', 'Pay amount');
        $form->number('add_time', 'Add time');
        $form->number('pay_time', 'Pay time');
        $form->number('status', 'Status')->default(1);
        $form->switch('is_delete', 'Is delete');

        return $form;
    }
}
