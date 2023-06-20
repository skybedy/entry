<div class="container">
<?php   if(!$this->VypisPrihlasek): ?>
	    <div class="panel panel-default contact"><div class="panel-body">
		Na tento závod ještě není nikdo přihlášen.
	    </div></div>
<?php   else:	echo $this->VypisPrihlasek; ?>
<?php   endif; ?>
</div>
