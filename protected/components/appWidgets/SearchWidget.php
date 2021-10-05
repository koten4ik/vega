<?php

class SearchWidget extends CWidget
{

	public  function run()
	{ ?>
            <div id="<?=$this->id?>">
            <form action="/shop/item/list">
                <input name="key" value="<? echo $_GET['key']; ?>" maxlength="50"/>
                <button type="submit" >Найти</button>
            </form>
            </div>
    <?
	}
}