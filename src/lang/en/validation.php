<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| The following language lines contain the default error messages used by
	| the validator class. Some of these rules have multiple versions such
	| as the size rules. Feel free to tweak each of these messages here.
	|
	*/

	"accepted"             => _("The :attribute must be accepted."),
	"active_url"           => _("The :attribute is not a valid URL."),
	"after"                => _("The :attribute must be a date after :date."),
	"alpha"                => _("The :attribute may only contain letters."),
	"alpha_dash"           => _("The :attribute may only contain letters, numbers, and dashes."),
	"alpha_num"            => _("The :attribute may only contain letters and numbers."),
	"array"                => _("The :attribute must be an array."),
	"before"               => _("The :attribute must be a date before :date."),
	"between"              => array(
		"numeric" => _("The :attribute must be between :min and :max."),
		"file"    => _("The :attribute must be between :min and :max kilobytes."),
		"string"  => _("The :attribute must be between :min and :max characters."),
		"array"   => _("The :attribute must have between :min and :max items."),
	),
	"boolean"              => _("The :attribute field must be true or false."),
	"confirmed"            => _("The :attribute confirmation does not match."),
	"date"                 => _("The :attribute is not a valid date."),
	"date_format"          => _("The :attribute does not match the format :format."),
	"different"            => _("The :attribute and :other must be different."),
	"digits"               => _("The :attribute must be :digits digits."),
	"digits_between"       => _("The :attribute must be between :min and :max digits."),
	"email"                => _("The :attribute must be a valid email address."),
	"exists"               => _("The selected :attribute is invalid."),
	"image"                => _("The :attribute must be an image."),
	"in"                   => _("The selected :attribute is invalid."),
	"integer"              => _("The :attribute must be an integer."),
	"ip"                   => _("The :attribute must be a valid IP address."),
	"max"                  => array(
		"numeric" => _("The :attribute may not be greater than :max."),
		"file"    => _("The :attribute may not be greater than :max kilobytes."),
		"string"  => _("The :attribute may not be greater than :max characters."),
		"array"   => _("The :attribute may not have more than :max items."),
	),
	"mimes"                => "The :attribute must be a file of type: :values.",
	"min"                  => array(
		"numeric" => "The :attribute must be at least :min.",
		"file"    => "The :attribute must be at least :min kilobytes.",
		"string"  => "The :attribute must be at least :min characters.",
		"array"   => "The :attribute must have at least :min items.",
	),
	"not_in"               => "The selected :attribute is invalid.",
	"numeric"              => "The :attribute must be a number.",
	"regex"                => "The :attribute format is invalid.",
	"required"             => "The :attribute field is required.",
	"required_if"          => "The :attribute field is required when :other is :value.",
	"required_with"        => "The :attribute field is required when :values is present.",
	"required_with_all"    => "The :attribute field is required when :values is present.",
	"required_without"     => "The :attribute field is required when :values is not present.",
	"required_without_all" => "The :attribute field is required when none of :values are present.",
	"same"                 => "The :attribute and :other must match.",
	"size"                 => array(
		"numeric" => "The :attribute must be :size.",
		"file"    => "The :attribute must be :size kilobytes.",
		"string"  => "The :attribute must be :size characters.",
		"array"   => "The :attribute must contain :size items.",
	),
	"unique"               => "The :attribute has already been taken.",
	"url"                  => "The :attribute format is invalid.",
	"timezone"             => "The :attribute must be a valid zone.",

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| Here you may specify custom validation messages for attributes using the
	| convention "attribute.rule" to name the lines. This makes it quick to
	| specify a specific custom language line for a given attribute rule.
	|
	*/

	'custom' => array(
		'attribute-name' => array(
			'rule-name' => 'custom-message',
		),
	),

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Attributes
	|--------------------------------------------------------------------------
	|
	| The following language lines are used to swap attribute place-holders
	| with something more reader friendly such as E-Mail Address instead
	| of "email". This simply helps us make messages a little cleaner.
	|
	*/

	'attributes' => array(),

    'validation-engine' =>[

    ]

);
