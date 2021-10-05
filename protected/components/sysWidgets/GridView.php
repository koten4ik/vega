<?php

Yii::import('zii.widgets.grid.CGridView');

class GridView extends CGridView
{
    public $cssFile = false;
    public $pagerCssClass ='myPager';
    public $selectableRows = 2;
    //public $ajaxUpdate = false;
    //public $pager = array('nextPageLabel' => '>', 'prevPageLabel' => '<', 'header' => '');
    public $summaryText = 'Элементы {start}-{end} из {count}';

	public function init()
	{
		 parent::init();
	}

    public function registerClientScript()
    {
        parent::registerClientScript();

        if(Yii::app()->request->enableCsrfValidation)
		{
			$csrfTokenName = Yii::app()->request->csrfTokenName;
			$csrfToken = Yii::app()->request->csrfToken;
			$csrf = "\n\t\tdata:{ '$csrfTokenName':'$csrfToken' },";
		}
		else
			$csrf = '';

        $amp = Y::app()->urlManager->urlFormat=='path'? '/?':'&';
        $js = <<<JAVASCRIPT
        function manageSelected(item, text, text_success) {

            var selectedItems = $.fn.yiiGridView.getSelection('{$this->id}');
            if(!selectedItems.length){ alert('Выберите один или несколько элементов'); return; }
            if(confirm(text)){
                var requestUrl  = item.attr('href') + '{$amp}';
                for (i=0;i<selectedItems.length;i++)
                    requestUrl += 'selectedItems[]=' + selectedItems[i] + "&";
                $.ajax( {
                    type:'POST',
                    url:requestUrl,
                    $csrf
                    success:function() {
                        $.fn.yiiGridView.update('{$this->id}');
                        showModMsg(text_success);
                    },
                });
            }
        }
        jQuery("a[id='deleteSelected']").live('click', function(e) {
            e.preventDefault();
            manageSelected($(this),'Подтверждения удаления.','Элемент(ы) удалены');
        });
        jQuery("a[id='archiveSelected']").live('click', function(e) {
            e.preventDefault();
            manageSelected($(this),'Переместить в архив ?','Элемент(ы) перемещены в архив');
        });
        /*jQuery("a[id='moveSelected']").live('click', function(e) {
            e.preventDefault();
            manageSelected($(this),'');
        });*/

        jQuery('a.selectAll').live('click',function(){jQuery('#{$this->id} tbody > tr').addClass('selected');});
        jQuery('a.selectNone').live('click',function(){jQuery('#{$this->id} tbody > tr').removeClass('selected');});
JAVASCRIPT;

		$cs = Yii::app()->getClientScript();

		$cs->registerScript(__CLASS__.'#'.$this->id,$js);

        //$this->controller->registerScript('$.fn.yiiGridView.update("'.$this->id.'");');
    }

    public function renderSummary()
   	{
        $one = 1;
   		if(($count=$this->dataProvider->getItemCount())<=0)
   			$one = 0;//return;

   		echo '<div class="'.$this->summaryCssClass.'">';
   		if($this->enablePagination)
   		{
   			if(($summaryText=$this->summaryText)===null)
   				$summaryText=Yii::t('zii','Displaying {start}-{end} of {count} result(s).');
   			$pagination=$this->dataProvider->getPagination();
   			$total=$this->dataProvider->getTotalItemCount();
   			$start=$pagination->currentPage*$pagination->pageSize+$one;
   			$end=$start+$count-$one;
   			if($end>$total)
   			{
   				$end=$total;
   				$start=$end-$count+1;
   			}
   			echo strtr($summaryText,array(
   				'{start}'=>$start,
   				'{end}'=>$end,
   				'{count}'=>$total,
   				'{page}'=>$pagination->currentPage+1,
   				'{pages}'=>$pagination->pageCount,
   			));
   		}
   		else
   		{
   			if(($summaryText=$this->summaryText)===null)
   				$summaryText=Yii::t('zii','Total {count} result(s).');
   			echo strtr($summaryText,array(
   				'{count}'=>$count,
   				'{start}'=>1,
   				'{end}'=>$count,
   				'{page}'=>1,
   				'{pages}'=>1,
   			));
   		}
   		echo '</div>';
   	}

    // старая реализяция сохраненния грида
    public $saveState = false;
    /*public function renderKeys()
    {
        $url = Yii::app()->getRequest()->getUrl();
        if($this->saveState){
            $url_s = Yii::app()->user->getState($this->id);
            if(isset($_GET['ajax']))
                Yii::app()->user->setState($this->id, Yii::app()->request->requestUri);
            else if( $url_s ) $url = $url_s;
        }
        echo CHtml::openTag('div',array(
            'class'=>'keys',
            'style'=>'display:none',
            'title'=>$url,
        ));
        foreach($this->dataProvider->getKeys() as $key)
            echo "<span>".CHtml::encode($key)."</span>";
        echo "</div>\n";
    }*/
}

?>