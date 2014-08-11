<?php

/**
 * Helper class to handle form-related actions
 */

// Shortcut function for validate form
// [Optional] set "form_url" for location of the form page
// [Optional] set "rule_set" for name of rule sets in config/form_validation.php (if empty, CodeIgniter will detect as "controller/method" pattern, e.g. "account/update")
function validate_form($form_url = '', $rule_set = '')
{
	$CI =& get_instance();
	$CI->load->library('form_validation');

	if ( $CI->form_validation->run($rule_set) == FALSE )
	{
		if ( validation_errors() )
		{
			// save error messages to flashdata
			set_alert('danger', validation_errors());

			// refresh or jump page to show error messagees
			$url = empty($form_url) ? current_url() : $form_url;
			redirect($url);
			exit();
		}
		
		// display form
		return FALSE;
	}
	else
	{
		// success
		return TRUE;
	}
}

// Text fields
function form_group_input($name, $value = '', $label = '', $placeholder = '', $required = FALSE)
{
	$label = empty($label) ? humanize($name) : $label;
	$placeholder = empty($placeholder) ? $label : $placeholder;
	$value = empty($value) ? set_value($name) : $value;
	$type = ($name=='email') ? 'email' : 'text';
	$required = $required ? 'required' : '';
	
	return "<div class='form-group'>
		<label for='$name'>$label</label>
		<input type='text' placeholder='$placeholder' id='$name' name='$name' class='form-control' value='$value' $required>
	</div>";
}

// Password fields
function form_group_password($name = 'password', $placeholder = '')
{
	$label = humanize($name);
	$placeholder = empty($placeholder) ? humanize($name) : $placeholder;
	
	return "<div class='form-group'>
		<div class='pi-input-with-icon'>
			<label for='$name'>$label</label>
			<input type='password' placeholder='$placeholder' id='$name' name='$name' class='form-control'>
		</div>
	</div>";
}

// Checkbox
function form_group_checkbox($name, $label)
{
	$active = empty($_GET[$name]) ? '' : 'checked';
	return "<div class='form-group'>
		<div class='checkbox'>
			<label><input type='checkbox' name='$name' style='margin:0' $active>&nbsp; $label</label>
		</div>
	</div>";
}

// Text fields (disabled)
function form_group_input_disabled($label, $value)
{
	return "<div class='form-group'>
		<label>$label</label>
		<input type='text' class='form-control' value='$value' disabled>
	</div>";
}

// Submit button (overrided)
function form_submit($label)
{
	return "<button class='btn btn-primary' type='submit'>$label</button>";
}

// Search bar (with inline icon)
function form_search($url = '', $placeholder = 'Search...', $name = 'q', $method = 'GET')
{
	$action = empty($url) ? '#' : site_url($url);
	return "<form action='$action' method='$method' class='sidebar-form'>
		<div class='input-group'>
			<input type='text' name='q' class='form-control' placeholder='$placeholder'/>
			<span class='input-group-btn'>
				<button type='submit' name='seach' id='search-btn' class='btn btn-flat'><i class='fa fa-search'></i></button>
			</span>
		</div>
	</form>";
}