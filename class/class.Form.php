<?php 


/**
* Form creator
*/
class ClassName extends AnotherClass
{
	
	function __construct($typeForm,$inputs=[],$submit=[])
	{
		# code...
	}

	public function newForm($typeForm,$inputs=[],$submit=[])
	{
		
	}

	$formItems = [
		['type' => 'text', 'class' => 'form-control', 'id' => 'idPersonal', 'name' => 'namePersonal', 'placeholder' => 'text'
		]
	]

	$input = '';
	foreach ($formItems as $key => $value) {
		if ($value['type'] == 'text') {
			$input .= '<div class="form-group">';

			if (isset($value['label']) AND $value['label'] != '') {
				$input .= '<label for="'$value['id']'">'$value['label']'</label>';
			}			
			$input .= '<input type="'$value['type']'" class="'$value['class']'" id="'$value[]'" placeholder="Email">';
			$input .= '<div class="form-group">';
		}
	}


	public function imprimirForm($inputs = '')
	{
		$form = '<form>';
		$form .= $imputs;
		$form .= '<form>';
	}
}

?>

<form>
  	<div class="form-group">
	    <label for="exampleInputEmail1">Email address</label>
	    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email">
	</div>
	  <div class="form-group">
	    <label for="exampleInputPassword1">Password</label>
	    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
	  </div>
	  <div class="form-group">
	    <label for="exampleInputFile">File input</label>
	    <input type="file" id="exampleInputFile">
	    <p class="help-block">Example block-level help text here.</p>
	  </div>
	  <div class="checkbox">
	    <label>
	      <input type="checkbox"> Check me out
	    </label>
	  </div>
	  <div class="checkbox">
	  <label>
	    <input type="checkbox" value="">
	    Option one is this and that&mdash;be sure to include why it's great
	  </label>
	</div>
	<div class="checkbox disabled">
	  <label>
	    <input type="checkbox" value="" disabled>
	    Option two is disabled
	  </label>
	</div>

	<div class="radio">
	  <label>
	    <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>
	    Option one is this and that&mdash;be sure to include why it's great
	  </label>
	</div>
	<div class="radio">
	  <label>
	    <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
	    Option two can be something else and selecting it will deselect option one
	  </label>
	</div>
	<div class="radio disabled">
	  <label>
	    <input type="radio" name="optionsRadios" id="optionsRadios3" value="option3" disabled>
	    Option three is disabled
	  </label>
	</div>
  <button type="submit" class="btn btn-default">Submit</button>
</form>