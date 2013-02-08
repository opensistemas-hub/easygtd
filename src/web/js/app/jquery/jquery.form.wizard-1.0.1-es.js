/*
 * jQuery wizard plug-in 1.0.1
 *
 *
 * Copyright (c) 2009 Jan Sundman (jan.sundman[at]aland.net)
 *
 * Licensed under the MIT licens:
 *   http://www.opensource.org/licenses/mit-license.php
 * 
 * Changelog:
 *  
 * version 1.0.1
 * -------------
 * - fixed so that the validation plugin handles all validation using form.valid(). 
 * - fixed so that it is possible set focus to a field in the form after the wizard is rendered
 * 
 * version 1.0.0
 * -------------
 * - fixed textarea validation
 * 
 * version 0.9.9
 * -------------
 * - Added a way to by-pass the reset functionality so that the $.fn.formwizard is not
 * 	 redefined. This is done by specifying 
 *
 *				callable : false 
 *
 *   in the wizard settings when initializing all wizards on a page. This means that the forms
 *	 cannot be reset but the initialization code will be run for all wizards. 
 * 
 * version 0.9.8
 * -------------
 * - Reworked the serverside validation part. One can specify the usual options used by the 
 *   form plugin for each step validation. To do server side validation for steps 1 and 4 the 
 *	 serverSideValidationUrls option for the wizard should be defined as in the examples below. 
 *   The field name "1" denotes that validation for step 1 should use that fields value as options
 *   when calling the validation service. Only the input fields on the current step will be sent
 *   (except on submit steps).
 *		
 *   If your validation service returns HTTP status 200 together with data specifying the status of the validation - use 
 *	 the success callback to check the data and take actions depending on it.
 *	 NOTE: The success callback should return true if the fields validated ok and false otherwise. 
 *   The variable 'validated' in the example below would be set to true if the page validated ok
 *		
 *
 *		serverSideValidationUrls : {"1" : {	"success" : function(data, textStatus){...do stuff...; return validated;}, 
 *																				"url" : "urltovalidationservice1.php" },
 *																"4" : {	"success" : function(data, textStatus){...do stuff...; return validated;}, 
 *																				"url" : "urltovalidationservice2.php" },
 *														    }
 *
 *		If your service returns HTTP status >200 together with data specifying the status of the validation - use 
 *    the error callback and take actions depending on the data returned.
 *
 *	  serverSideValidationUrls : {"1" : {	"error" : function(XMLHttpRequest, textStatus, errorThrown){alert("check for errors in the data, HTTP status >200");}, 
 *																				"url" : "urltovalidationservice1.php" },
 *																"4" : {	"error" : function(XMLHttpRequest, textStatus, errorThrown){alert("check for errors in the data, HTTP status >200");}, 
 *																				"url" : "urltovalidationservice2.php" },
 *															 }
 *
 * 
 * version 0.9.7
 * -------------
 * - Added a way to reset the wizard by calling $("#theform").formwizard("reset");
 * - The afterBack and afterNext callbacks now get some information about the plugin
 * 
 * version 0.9.6
 * -------------
 * - Fix for enabling select validation
 * 
 * version 0.9.5
 * -------------
 * - Fix for enabling optional validation
 *
 * version 0.9.4
 * -------------
 * - Performance fixes for validation of the steps
 * - Performance fixes for rendering of the steps
 * - Introduces a need for input fields in the wizard to be disabled in the html
 *
 * version 0.9.3
 * ------------- 
 * - Fixed the continueToNextStep and backButton.click callback to handle navigation correctly when the 
 * history plugin is not used
 * 
 * version 0.9.2 
 * -------------
 * - A check was added to see if there are multiple links on one step. In the
 * case there are we assume they are radio buttons or checkboxes. Only the
 * one that is checked is considered a valid link. This fixes a bug where links
 * in the form of radio buttons do not work. Credits to adnanshareef for 
 * reporting the bug.  
 * 
 * - Added initial functionality for doing server-side validation 
 * 
 * version 0.9.1 
 * -------------
 * - Addition of afterNext and afterBack callbacks, can be used to do stuff after
 * the rendering of a step has been completed
 * 
 * version 0.9.0 
 * -------------
 * - Initial release
 *
 */
   
(function($){
	

  $.fn.formwizard = function(wizardSettings, validationSettings, formOptions){
	
	/**
	 * Creates a wizard of all matched elements
	 *
	 * @constructor
	 * @name $.formwizard
	 * @param Hash wizardSettings A set of key/value pairs to set as configuration properties for the wizard plugin.
	 * @param Hash validationSettings A set of key/value pairs to set as configuration properties for the validation plugin.
	 * @param Hash formOptions A set of key/value pairs to set as configuration properties for the form plugin.
	 */	  	
	
	var settings = $.extend({
		historyEnabled	: false,
		validationEnabled : false,
		formPluginEnabled : false,
		linkClass	: ".link",
		submitStepClass : ".submit_step",
		back : ":reset",
		next : ":submit",
		textSubmit : 'Grabar',
		textNext : 'Siguiente',
		textBack : 'Anterior',
		afterNext: undefined,
		afterBack: undefined,
		serverSideValidationUrls : undefined,
		callable : true
	}, wizardSettings);

	var formOptionsSuccess = (formOptions)?formOptions.success:undefined;
	var formSettings = $.extend(formOptions,{
		success	: function(data){ 
			if(formOptions && formOptions.resetForm || !formOptions){
				navigate(0);
				if(settings.historyEnabled){
					$.historyLoad(0);
				}else{
					renderStep();
				}
			}
			if(formOptionsSuccess){
				formOptionsSuccess(data);
			}else{
				alert("success");
			}
		}
	});
	var currentStep = 0;
	var previousStep = undefined;	
	var form = $(this);
	var steps = $(this).find(".step");
	var backButton = $(this).find(settings.back);
	var nextButton = $(this).find(settings.next);
	var activatedSteps = new Array();
	var isLastStep = false;	

	/** 
	 * Navigation event callbacks 
	 */
	nextButton.click(function(){		
		if(settings.validationEnabled){
			if(!form.valid()){form.validate().focusInvalid();return false;}
		}
		if(isLastStep){
			if(settings.formPluginEnabled){
				form.ajaxSubmit(formSettings);
				return false;
			}
			form.submit();
			return false;
		}

		// Doing server side validation for the steps
		if(settings.serverSideValidationUrls){
		  var options = settings.serverSideValidationUrls[currentStep];
			if(options != undefined){ 
			  var success = options.success;
				$.extend(options,{success: function(data, statusText){
						if((success != undefined && success(data, statusText)) || (success == undefined)){
							continueToNextStep();
						}
					}})
				form.ajaxSubmit(options);
				return false;
			}
		}
		continueToNextStep();
		return false;
	});

	backButton.click(function(){
		if(settings.historyEnabled && activatedSteps.length > 0){
			history.back();
		}else if(activatedSteps.length > 0){
			handleHistory(activatedSteps[activatedSteps.length - 2]);
		}
		if(settings.afterBack)	
			settings.afterBack({"currentStep" : currentStep, 
													"previousStep" : previousStep,
													"isLastStep" : isLastStep, 
													"activatedSteps" : activatedSteps});
		return false;
	});

	/**
	 * Continues to the next step in the wizard
	 */
	function continueToNextStep(){
		navigate(currentStep);
		renderStep();

		if(settings.historyEnabled){
			$.historyLoad(currentStep);
		}else{
			handleHistory(currentStep);
		}

		if(settings.afterNext)
			settings.afterNext({"currentStep" : currentStep, 
													"previousStep" : previousStep,
													"isLastStep" : isLastStep, 
													"activatedSteps" : activatedSteps});
	}

    /**
     * Renders the current step and disables the input fields in other steps
     *
     * @name renderStep
     * @type undefined
     */
	function renderStep(){
		backButton.removeAttr("disabled");
		nextButton.val(settings.textNext);

			if(previousStep != undefined){
				steps.eq(previousStep).hide()
					.find(":input")
					.attr("disabled","disabled");
			}

			steps.eq(currentStep)
			.fadeIn()
			.find(":input")
			.removeAttr("disabled");

		if(isLastStep){
			for(var i = 0; i < activatedSteps.length; i++){
				steps.eq(activatedSteps[i]).find(":input").removeAttr("disabled");
			}
			nextButton.val(settings.textSubmit);
		}else if(currentStep == 0){
			backButton.attr("disabled","disabled");
		}
	}

    /**
     * Checks if the step is the last step in a wizard route
     *
     * @name checkIflastStep
     * @type undefined
     * @param Number step The step to check.
     */			
	function checkIflastStep(step){
		var link = getLink(step);

		isLastStep = false;
		
		if((("." + link) == settings.submitStepClass) || (link == undefined && (step*1) == steps.length - 1)){
			isLastStep = true;
		}
	}

    /**
     * Decides and sets the current step in the wizard 
     *
     * @name navigate
     * @type undefined
     * @param Number step The step to navigate from.
     */
	function navigate(step){
		var link = getLink(step);

		if(link){					
			var navigationTarget = steps.index($("#" + link));	
			if(navigationTarget == -1){
				return;
			}else{
				previousStep = currentStep;
				currentStep = navigationTarget;	
			}
			checkIflastStep(step);			
		}else if(link == undefined && !isLastStep){	
			previousStep = currentStep;
			currentStep++;
			checkIflastStep(currentStep);
		}
	}

    /**
     * Finds the valid link for the step (if there is one)
     *
     * @name getLink
     * @type String
     * @param Number step The step to search for valid links
     */
	function getLink(step){
		var link = undefined;
		var links = steps.eq((step*1)).find(settings.linkClass);

		if(links != undefined && links.length == 1){
			link = links.val();
		}else if(links != undefined && links.length > 1){ 
			// assume that the link is a radio button or checkbox
			link = steps.eq((step*1)).find(settings.linkClass + ":checked").val();
		}
		return link;
	}

    /**
     * Handles back navigation (and browser back and forward buttons if history is enabled)
     *
     * @name handleHistory
     * @type undefined
     * @param String hash The hash used in the browser history
     */
	function handleHistory(hash){
		if(!hash){
			hash = 0;
		}
		if(activatedSteps[activatedSteps.length - 2] == hash){
			var elem = activatedSteps.pop();	
		}else {
			activatedSteps.push(hash);
		}
		previousStep = currentStep;
		currentStep = hash;
		checkIflastStep(hash);
		renderStep();
	}
	
	   /**
     * Resets the wizard to its original state
     *
     * @name resetWizard
     * @type undefined
     */
	function resetWizard(){
		form.resetForm();
		currentStep = 0;
		for(var i = 0; i < activatedSteps.length; i++){
			steps.eq(activatedSteps[i]).hide().find(":input").attr("disabled","disabled");
		}
		previousStep = undefined;	
		activatedSteps = new Array();
		isLastStep = false;	
		if(settings.historyEnabled){
			$.historyLoad(0);
		}else{
			renderStep();
		}
	}
	
    /**
     * Initialization
     */
	
	if(settings.validationEnabled && jQuery().validate  == undefined){
		settings.validationEnabled = false;
		alert("the validation plugin needs to be included");
	}else if(settings.validationEnabled){
		form.validate(validationSettings);
	}
	
	if(settings.formPluginEnabled && jQuery().ajaxSubmit == undefined){
		settings.formPluginEnabled = false;
		alert("the form plugin needs to be included");
	}

	steps.hide();
	
	if(settings.historyEnabled && $.historyInit  == undefined){
		settings.historyEnabled = false;
		alert("the history plugin needs to be included");
	}else if(settings.historyEnabled){
		$.historyInit(handleHistory);
	}else{
		handleHistory(0);
  }
	
	backButton.val(settings.textBack);
	
	if(settings.callable == true){
		// provides a way of calling internal methods (note that $.fn.formwizard is redefined)
		$.fn.formwizard = function(event){
			switch(event){
				case 'reset':	resetWizard(); break;
			}
			return $(this);
		};
  }
  return $(this);
  };
})(jQuery);
