<?php

class CartController extends FrontEndController
{
    public $layout = 'shop';
    public $defaultAction = 'view';

    public function actionAdd($id, $quantity = 1, $options_data)
	{
        $position=CatalogItem::model()->findByPk($id);
        $position->optionsData = $options_data;
        $this->cart->put($position,$quantity);

        $this->actionGetData();
	}

    public function actionGetData()
	{
        $cart['itemsCount'] = $this->cart->getItemsCount();
        $cart['cost'] = $this->cart->getCost();
        echo CJSON::encode($cart);
	}

    public function actionView()
    {
        $this->pageTitle = Yii::app()->name.' - Корзина';
        $this->render('view',array(  ));
    }

    public function actionUpdate()
    {
        if($_GET['delId'] == 'all') $this->cart->clear();
        if($_GET['delId'] > 0){
            $item = CatalogItem::model()->findByPk($_GET['delId']);
            $this->cart->remove($item->getId());
        }
        if($_GET['updId'] > 0){
            $item = CatalogItem::model()->findByPk($_GET['updId']);
            $this->cart->update($item, $_GET['quantity']);
        }
        $this->renderPartial('_cart',array(  ));
    }

    public function actionCheckout()
    {
        if($this->cart->getItemsCount() == 0)
            $this->redirect(array('view'));

        $model=new CatalogOrder;

        if(isset($_POST['CatalogOrder']))
        {
            $model->attributes=$_POST['CatalogOrder'];
            $model->total = $this->cart->cost;
            $model->status = CatalogOrder::PAY_WAIT;
            foreach($positions = $this->cart->getPositions() as $key=>$position)
                $model->products .= $position->id.'&'.$position->getQuantity().'&'.
                    $position->optionsData.'~';

            if($model->save())
            {
                foreach($positions = $this->cart->getPositions() as $key=>$position)
                    if($position->category->alias == 'reserve'){
                        $reserv = new CatalogItemReserve();
                        $reserv->cdate = time();
                        $reserv->item_id = $position->id;
                        $reserv->count = $position->getQuantity();
                        $reserv->order_id = $model->id;
                        $reserv->save();
                    }


                $message = $this->renderPartial('_order_mail',
                    array('order'=>$model, 'positions'=>$this->cart->getPositions()),true);
                $mailer = Yii::createComponent('application.extensions.mailer.EMailer');
                $mailer->IsSMTP();
                $mailer->From = $this->config->mail_from;
                $mailer->AddAddress($this->config->mail_to_shop);
                $mailer->FromName = $this->config->mail_from_name;
                $mailer->CharSet = 'UTF-8';
                $mailer->Subject = 'Заказ №'.$model->id;
                $mailer->Body = $message;
                $mailer->Send();

                $this->cart->clear();
                $this->redirect(array('successOrder'));
            }
        }
        else{
            //foreach ($_COOKIE as $name=>$val ) setcookie ($name, "", time() - 3600);
            $model->attributes = $_COOKIE['CatalogOrder'];
            //$model->ship_method = null;
            //$model->pay_method = null;
        }

        $this->pageTitle = Yii::app()->name.' - оформление заказа';
        $this->render('checkout',array(
            'model'=>$model,
            'ships'=> new CatalogShipping(),
            'pays'=> new CatalogPayment(),
        ));
    }

    public function actionSuccessOrder()
    {
        $this->render('successOrder',array(  ));
    }

    public function  getCart(){ return Yii::app()->shoppingCart; }
}
