/**
 * AQPB js
 *
 * contains the core js functionalities to be used
 * inside AQPB
 * Modified - built on Aquapage builder.
 */
jQuery.noConflict();
/** Fire up jQuery - let's dance! **/
jQuery(document).ready(function($){

	var pagebuilderSpace = $("#blocks-to-edit");
    var undoStack = new Array;

    var undoCounter = 0;
    var maxCounter = 0;
    var undoButton = '.em_undo';
    var redoButton = '.em_redo';
    pagebuilderElements = pagebuilderSpace.html();


    // https://css-tricks.com/snippets/jquery/make-jquery-contains-case-insensitive/
	$.expr[":"].contains = $.expr.createPseudo(function(arg) {
	    return function( elem ) {
	        return $(elem).text().toUpperCase().indexOf(arg.toUpperCase()) >= 0;
	    };
	});

    function UndoSetSortables() {
		$('ul.blocks li.block.ui-resizable').removeClass('ui-resizable');
		$('ul.blocks li.block .ui-resizable-handle').remove();
		resizable_blocks();
		columns_sortable();
		aq_sortable_list_init();
    }

    function undoSave() {
        // Save current state
        pagebuilderElements = pagebuilderSpace.html();
        undoStack = undoStack.slice(0,undoCounter);
        undoStack[undoCounter] = (pagebuilderElements);
        ++undoCounter;

        UndoStateChangeStatus();
        
        maxCounter = undoCounter;

    }

    function UndoStateChangeStatus() {
    	// check if undo is available
    	if (undoCounter <= 0) {
    		$(undoButton).addClass('disabled');
    	} else {
    		$(undoButton).removeClass('disabled');
    	}
    	// otherwise
    	if ( maxCounter > undoCounter ) {
    		$(redoButton).removeClass('disabled');
    	} else {
    		$(redoButton).addClass('disabled');
    	}
    }

    $(undoButton).click(function () {
    	if(!$(this).hasClass('disabled')) {
	        if (undoStack.length > 0 && undoCounter > 0) {

	            pagebuilderElements = pagebuilderSpace.html();
	            undoStack[undoCounter] = (pagebuilderElements);

	            --undoCounter;

	            pagebuilderSpace.html(undoStack[undoCounter]);
	            UndoSetSortables();
	            UndoStateChangeStatus();
	        }
    	}
        return false;
    });

    $(redoButton).click(function () {
    	if(!$(this).hasClass('disabled')) {
	    	if ( maxCounter > undoCounter ) {
	    		++undoCounter;
		        pagebuilderSpace.html(undoStack[undoCounter]);
		    }

	        UndoSetSortables();
	        UndoStateChangeStatus();
    	}
    	return false;
    });

	$('#blocks-archive').show();
	$('.mtheme-edit-pb-wrap').show()
	
	var pb_isactive = $('#mtheme_pb_isactive').val();

	function set_pb_status(pb_isactive) {
		if (!pb_isactive) {
			//$('#postdivrich').show();
			$('body').removeClass('pagebuilder-active-page');
			$(window).trigger('resize');
			$('#aq-page-builder').hide();
			$('.mtheme-edit-visual,.mtheme-edit-pb').hide();
			$('.mtheme-edit-null').slideDown();
		}
		// is set to either
		if (pb_isactive=='1' || pb_isactive=='2') {
			$('.mtheme-edit-null').slideUp();
		}
		// if requires changing
		if (pb_isactive=='3') {
			$('.mtheme-edit-null').slideToggle();
		}
		// if builder is active
		if (pb_isactive=='1') {
			//$('#postdivrich').hide();
			$('body').addClass('pagebuilder-active-page');
			$('#aq-page-builder').show();
			$('.mtheme-edit-visual').hide();
			$('.mtheme-edit-pb').show();
		}
		// if visual editor is set
		if (pb_isactive=='2') {
			//$('#postdivrich').show();
			$('body').removeClass('pagebuilder-active-page');
			$(window).trigger('resize');
			$('#aq-page-builder').hide();
			$('.mtheme-edit-visual').show();
			$('.mtheme-edit-pb').hide();
		}
	}
	set_pb_status(pb_isactive);

	$('.mtheme-pb-yes').on('click', function(){
		$('#mtheme_pb_isactive').val("1");
		set_pb_status('1');
	});
	$('.mtheme-pb-no').on('click', function(){
		$('#mtheme_pb_isactive').val("2");
		set_pb_status('2');
	});
	$('.mtheme-pb-change').on('click', function(){
		set_pb_status('3');
	});

	// All stations go
	pagebuilder_VerifyBlocks();
	update_block_order();
	update_block_number();

	var animation_class = "animated";
	var animation_add = "fadeIn";
	var animation_delete = "";

	$('#blocks-archive').find('ul').find('[data-toggle="tooltip"]').tooltip();

	var data_body = $('#aqpb-body');
	//enable all disabled inputs in builder
	data_body.find('input, select, textarea').not('[type="submit"]').attr("disabled", false);

	// the replicator
	function pagebuilder_block_clone( duplicateElement , duplicateID,randomKey) {
		var replaceSlugs = [ 'template-block-', 'my-content-', 'block-settings-', 'aq_block_' ];
		var replacementRegex = new RegExp( '((' + replaceSlugs.join( '|' ) + ')' + duplicateID + ')', 'gim' );
		var newstring = duplicateElement.replace( replacementRegex, function( match, p1, p2 ) {
		    //console.log('matches :' + match);
		    //console.log('p2 :' + p2 + randomKey);
		    return p2 + randomKey;
		});
		//console.log('ns :' + newstring);
		return newstring;

	}

	function pagebuilder_VerifyBlocks() {
		activeBlockIDs = new Array;
		$('#blocks-to-edit .block').each(function(index,element) {
			activeBlockIDs[index] = $(element).attr('id');
		});
		do {
			// get duplicate id one by one
			var id = pagebuilderCheck_DuplicateBlocks(activeBlockIDs);

			for(i = 0; i< id.length; i++) {
				duplicate = id[i];
				$("#"+duplicate).each(function(index,element) {

					var randomKey = generateRandomKey();
					$(element).attr('id',randomKey);
					
					randomKey = randomKey.substr(9);
					duplicate = duplicate.substr(15);
					// clone it with new IDs and classes
                    $(element)[0].outerHTML = pagebuilder_block_clone( $(element)[0].outerHTML , duplicate , randomKey);
				});
				
				activeBlockIDs = new Array;
				$('#blocks-to-edit .block').each(function(index,element,randomKey) {
					activeBlockIDs[index] = $(element).attr('id');
				});
			}
		} while( pagebuilderCheck_DuplicateBlocks(activeBlockIDs).length !== 0);
		return true;
	}
	function pagebuilderCheck_DuplicateBlocks(activeBlockIDs){
		//var t0 = performance.now();
	    var itm, proccessArray = activeBlockIDs.slice(0, activeBlockIDs.length), dups= [];
	    while(proccessArray.length){
	    	// remove the item as it checks.
	    	// Faster as the array reduces the second turn with
	    	// the item checked again
	        itm= proccessArray.shift();
	        // See if the array exisit. -1 if it is not
	        if(proccessArray.indexOf(itm)!= -1){
	        	// has dups. add it to dups array
	            dups[dups.length]= itm;
	            // go through and all of them
	            while(proccessArray.indexOf(itm)!= -1){
	            	// remove each encounter
	                proccessArray.splice(proccessArray.indexOf(itm), 1);
	            }
	        }
	    }

		//var t1 = performance.now();
		//console.log(dups);
		//console.log("Call for 2 took " + (t1 - t0) + " milliseconds.");

		return dups;
	}

    $( document ).on( 'click', '[data-toggle="stackablemodal"]', function() {
        $( $( this ).attr( 'href' ) )
                 .one( 'show.bs.modal', function() {
                    var $this = $( this );
                    // modals
		            if ( $this.attr( 'id' ) == "pagebuilder-icon-picker-modal" ) {
		                $this.data('bs.modal').options.backdrop = false;
		            }
                    $this.parents('.em_popup').removeClass('em_popup').addClass('addLater');
		        })
                .one( 'shown.bs.modal', function() {
                	$( document.body ).removeClass( 'modal-open' );
                    var $this = $( this );

                    var the_id_got = 'aq_block_' + $this.attr( 'id' ).substring( 15 );
                    var id_value = $this.attr( 'id' ).substring( 15 );

					console.log(id_value);

					$( '#block-settings-' + id_value + ' .wp-editor-area').each(function(index,element) {
						richtext_main_id = $(this).attr( 'id' );
						console.log(richtext_main_id);
	         			$('#' + richtext_main_id).wp_editor();
                    });

                    $(document).off('focusin.modal');

					// TinyMCE to child
					jQuery('#block-settings-' + id_value + ' .child-richtext-block').each(function(index,element) {
						richtext_child_id = $(this).attr( 'id' );
						console.log ( richtext_child_id );
                    	tinyMCE.init({
                    		mode : "none",
                    		plugins: "textcolor",
						    toolbar: [
						        "newdocument bold italic underline strikethrough alignleft aligncenter alignright alignjustify bullist numlist outdent indent blockquote undo redo",
						        "removeformat subscript superscript styleselect formatselect cut copy paste forecolor backcolor"
						    ]
                    	});
						tinyMCE.execCommand('mceAddEditor', false, richtext_child_id );
					});

                } )
                .one( 'hide.bs.modal', function() {
                    var $this = $( this );
                    $this.parents('.addLater').removeClass('addLater').addClass('em_popup');

                    var the_id_got = 'aq_block_' + $this.attr( 'id' ).substring( 15 );
                    var id_value = $this.attr( 'id' ).substring( 15 );

                    var user_div_id = $('#block-settings-' + id_value).find('.blockID').val();
                    $('#template-block-' + id_value).find('.user-control-id').text(user_div_id);

                    var user_note_self = $('#block-settings-' + id_value).find('.blockNote').val();
                    $('#template-block-' + id_value).find('.blocknote-self').text(user_note_self);

                    $( '#block-settings-' + id_value + ' .wp-editor-area').each(function(index,element) {
                    	richtext_main_id = $(this).attr( 'id' );
                    	console.log(richtext_main_id);
					    if ( $('#wp-' + richtext_main_id+'-wrap').hasClass("tmce-active") ){
					        $('#' + richtext_main_id).text(tinyMCE.get(richtext_main_id).getContent());
					    }else{
					        $('#' + richtext_main_id).text( $('#' + richtext_main_id).val() );
					    }
						console.log(tinyMCE.get(richtext_main_id).getContent());
						tinyMCE.execCommand( 'mceRemoveEditor', true, richtext_main_id );
						
						console.log( $('#' + richtext_main_id).val() );
                    });

					current_sortable_id = $this.attr( 'id' ).substring( 15 );
					$( '#aq-sortable-list-aq_block_'+ current_sortable_id + ' li .child-richtext-block').each(function(index,element) {
						richtext_child_id = $(this).attr( 'id' );
						tinyMCE.get( richtext_child_id ).save();
						tinyMCE.execCommand( 'mceRemoveEditor', true, richtext_child_id );
					});

                } )
                .one( 'hidden.bs.modal', function() {
                    var $this = $( this );

                    var id_value = $this.attr( 'id' ).substring( 18 );
                    var user_div_id = $('#my-column-content-' + id_value).find('.blockID').val();
                    $('#template-block-' + id_value + ' > .block-bar .block-handle').find('.user-control-id').text(user_div_id);

                    var user_note_self = $('#my-column-content-' + id_value).find('.blockNote').val();
                    $('#template-block-' + id_value + ' > .block-bar .block-handle').find('.blocknote-self').text(user_note_self);
                } )
                .modal( 'show', this );

    });

	generatetoolTips();

	var pageBuilderID = $('#page-builder');
	pageBuilderID.on('click','.blocksizeincr',function(e) {
		blocksizeincr($(this),e);
	});
	pageBuilderID.on('click','.blocksizedecr',function(e) {
		blocksizedecr($(this),e);
	});

	var blockDimension = new Array(
		16.66666667,
		25,
		33.33333333,
		41.66666667,
		50,
		58.33333333,
		66.66666667,
		75,
		83.33333333,
		91.66666667,
		100
	);
    var columnDimension = new Array(
		[],
		[],
		[100,100,100,100,100,100,100,100,100,100,100],
		[66.66666666,100,100,100,100,100,100,100,100,100,100],
		[50,75,100,100,100,100,100,100,100,100,100],
		[40,60,80,100,100,100,100,100,100,100,100],
		[33.33333333,50,66.66666666,83.33333333,100,100,100,100,100,100,100],
		[28.57142857,42.85714286,57.14285714,71.42857142,85.71428571,100,100,100,100,100,100],
		[25,37.5,50,62.5,75,87.5,100,100,100,100,100],
		[22.22222222,33.33333333,44.44444444,55.55555555,66.66666666,77.77777777,88.88888888,100,100,100,100],
		[20,30,40,50,60,70,80,90,100,100,100],
		[18.18181818,27.27272727,36.36363636,45.45454545,54.54545454,63.63636363,72.72727272,81.81818181,90.90909090,100,100],
		[16.66666667,25,33.33333333,41.66666667,50,58.33333333,66.66666667,75,83.33333333,91.66666667,100]
	);

	var block_archive,
		block_number,
		parent_id,
		block_id,
		intervalId,
		resizable_args = {
			handles: 'e',
			minWidth: 85,
			start: function(event, ui) {
				if($(ui.helper).hasClass('mtheme-columns')) {
					$(ui.helper).find('li.block').each(function(index,element) {
						$(element).width($(element).width());
					});
				}
			},
			resize: function(event, ui) {
			    ui.helper.css("height", "inherit");
			    var ui_size = ui.size.width/$('#blocks-to-edit').width()*100;
			    var new_block_size = blockDimension[10];

			    if(ui_size <= blockDimension[0]) {
			    	new_block_size = blockDimension[0];
		        }
			    var next_block_val = 0;
			    // Walk through current block and determine new block size
				for (var i=0; i < 10; i++) {
					next_block_val = i + 1;
					//console.log(i,next_block_val);
					if(ui_size >= blockDimension[i] && ui_size <= blockDimension[next_block_val]) {
						new_block_size = blockDimension[next_block_val];
					}
				}
				// Set new block size
		        $(this).css('width',new_block_size+'%');
			},
			stop: function(event, ui) {
				console.log('Reached 1');
				ui.helper.css('left', ui.originalPosition.left);
				$(ui.helper).toggleClass( function (index, css) {
				    return (css.match (/\bspan\S+/g) || []).join(' ') + ' ' + block_size( $(ui.helper).width());
				});
				if($(ui.helper).hasClass('mtheme-columns')) {
					 $(ui.helper).find('.block-settings-column').find('.size').last().val(block_size( $(ui.helper).width() ));

					if($(ui.helper).find('li.block').length) {
						console.log('Found blocks');
						$(ui.helper).find('li.block').each(function (count,element) {
							$(element).css('width','');

							var column_span_value = parseInt($(ui.helper).find('.size').last().val().substring(4));
							var column_span_text_value = $(ui.helper).find('.size').last().val().substring(4);
							var element_span_value = parseInt($(element).find('.size').val().substring(4));

							var column_span_class = 'span'+column_span_value;

							//console.log( 'DUOS ' + column_span_value , element_span_value );

							if(column_span_value <= element_span_value) {
								var parent_span = $('.size[name*='+$(ui.helper).attr('id').substring('15')+']').val();
								$(element).toggleClass (function (index, css) {
								    return (css.match (/\bspan\S+/g) || []).join(' ') + ' ' + column_span_class ;
								});
								$(element).find('.block-settings').find('.size').val(column_span_class);
							}
						});

					}
				} else {
					$(ui.helper).find('.block-settings').find('.size').val(block_size( $(ui.helper).width() ));
					var parent_span = $(ui.helper).find('.size').val();
				}
				$(ui.helper).css('width','');
				entityBlockSpan($(ui.helper).children('div'));
			}
		},
		resizable_col_args = {
			handles: 'e',
			minWidth: 85,
			start: function() {
			},
			resize: function(event, ui) {
			    ui.helper.css("height", "inherit");
				var column_size = ui.element.parents('.mtheme-columns').find('.block-settings-column').find('.size').last().val();
				set_new_column_span($(this),column_size,ui);
			},
			stop: function(event, ui) {
				console.log('Reached 3');
				ui.helper.css('left', ui.originalPosition.left);
				ui.helper.removeClass (function (index, css) {
				    return (css.match (/\bspan\S+/g) || []).join(' ');
				}).addClass(block_size_incolumn( $(ui.helper).width(), $(ui.helper).parents('.mtheme-columns')));
				if($(ui.helper).hasClass('mtheme-columns')) {
					ui.helper.find('.block-settings-column').find('.size').first().val(block_size_incolumn( $(ui.helper).width(), $(ui.helper).parents('.mtheme-columns') ));
				} else {
					ui.helper.find('.block-settings').find('.size').val(block_size_incolumn( $(ui.helper).width(), $(ui.helper).parents('.mtheme-columns') ));
				}
				$(ui.helper).css('width','');
				entityBlockSpan($(ui.helper).children('div'));
			}
		},
		tabs_width = $('.aqpb-tabs').outerWidth(),
		mouseStilldown = false,
		max_marginLeft = 720 - Math.abs(tabs_width),
		activeTab_pos = $('.aqpb-tab-active').next().position(),
		act_mleft,
		$parent,
		$clicked;

	function set_new_column_span(elementy,span,ui) {
		console.log('Reached 5');

		var the_col_span = 2;

		switch (span){
			case 'span12':
				the_col_span = 12;
			break;
			case 'span11':
				the_col_span = 11;
			break;
			case 'span10':
				the_col_span = 10;
			break;
			case 'span9':
				the_col_span = 9;
			break;
			case 'span8':
				the_col_span = 8;
			break;
			case 'span7':
				the_col_span = 7;
			break;
			case 'span6':
				the_col_span = 6;
			break;
			case 'span5':
				the_col_span = 5;
			break;
			case 'span4':
				the_col_span = 4;
			break;
			case 'span3':
				the_col_span = 3;
			break;
			case 'span2':
				the_col_span = 2;
			break;
		}
		//console.log(the_col_span,span);
		var column_width = ui.element.parents('.mtheme-columns').width();
		var ui_width = ui.size.width/column_width*100;

		var new_col_size = columnDimension[the_col_span][10];

		if(ui_width <= columnDimension[the_col_span][0]) {
			elementy.css('width',columnDimension[the_col_span][0]+'%');
			new_col_size = columnDimension[the_col_span][0];
			
		}

	    var next_col_val = 0;
	    // Walk through current column and determine new block size
		for (var i=0; i < 10; i++) {
			next_col_val = i + 1;
			//console.log(i,next_col_val);
			if(ui_width >= columnDimension[the_col_span][i] && ui_width <= columnDimension[the_col_span][next_col_val]) {
				new_col_size = columnDimension[the_col_span][next_col_val];
			}
		}

		elementy.css('width',new_col_size+'%');
		entityBlockSpan($(ui.helper).children('div'));
	}

	function makeid()
	{
		do {
			id = _.uniqueId('dynamic_');
		} while ( $('#template-block-' + id).length !== 0 );

	   return id;
	}

	function generateRandomKey() {
		var text = "aq_block_";
	    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
		   for( var i=0; i < 5; i++ )
			   text += possible.charAt(Math.floor(Math.random() * possible.length));

		return text;
	}

	function block_size(width) {
		var span = "span12";
		width = parseInt(width);
		var ui_size = width/$('#blocks-to-edit').width()*100;

	    var next_block_size = 0;

	    if (ui_size <= blockDimension[0]) { span = "span2"; }

	    // Walk through current block and determine new block size
		for (var i=0; i < 10; i++) {
			next_block_size = i + 1;
			the_block_set_size = next_block_size + 2;
			//console.log('block size: ',i,next_block_size,the_block_set_size);
			if (ui_size > blockDimension[i] && ui_size <= blockDimension[next_block_size]){
				span = "span" + the_block_set_size;
			}
		}
		return span;
	}
	function block_size_incolumn(width,parent) {
		var span = "span12";
		width = parseInt(width);
		var parent_width = parent.width();
		var ui_width = width/parent_width*100; // width in percentage
		var size = parent.find('.block-settings-column').find('.size').last().val().substring(4);
		//console.log('the size :' + size);
		//console.log('ui_width :' + ui_width);


		if(ui_width <= columnDimension[size][0]) {
			span = "span2";
		}

		// Walk through columns and set the size
		for (var i=0; i < 10; i++) {
			next_col_size = i + 1;
			the_col_set_size = next_col_size + 2;
			//console.log('col size: ',i,next_col_size,the_col_set_size);
			if(ui_width >= columnDimension[size][i] && ui_width <= columnDimension[size][next_col_size]){
				span = "span" + the_col_set_size;
			}
		}
		return span;

	}

	function resizable_dynamic_width(blockID) {
		var blockPar = $('#' + blockID).parent(),
			maxWidth = parseInt($(blockPar).parent().parent().css('width'));

		$('#' + blockID).bind( "resizestop", function(event, ui) {
			if($('#' + blockID).hasClass('block-em_column_block') ) {
				var $blockColumn = $('#' + blockID),
					new_maxWidth = parseInt($blockColumn.css('width'));
					child_maxWidth = new Array();
				var minWidth = Math.max.apply( Math, child_maxWidth );
				$('#' + blockID + '.ui-resizable').resizable( "option", "minWidth", minWidth );
			}

			$('#' + blockID + '.ui-resizable').css({"position":"","top":"auto","left":"0px"});

		});

	}

	function update_block_order() {
		$('ul.blocks').each( function() {
			$(this).children('li.block').each( function(index, el) {
				$(el).find('.order').last().val(index + 1);
				//console.log(el);
				if($(el).parent().hasClass('column-blocks')) {
					parent_order = $(el).parent().siblings('.order').val();
					$(el).find('.parent').last().val(parent_order);
				} else {
					$(el).find('.parent').last().val(0);
					if($(el).hasClass('block-em_column_block') ) {
						block_order = $(el).find('.order').last().val();
						$(el).find('li.block').each(function(index,elem) {
							$(elem).find('.parent').val(block_order);
						});
					}
				}

			});
		});
	}

	function update_block_number() {
		$('ul.blocks li.block').each( function(index, el) {
			$(el).find('.number').last().val(index + 1);
		});
	}

	function columns_sortable() {
		$('#page-builder .column-blocks').sortable({
			placeholder: 'placeholder',
			start: function(e, ui){
				var current_item_width = $(ui.item).width();
				//console.log(current_item_width);
			    $(ui.placeholder).width(current_item_width);
			    $(ui.placeholder).hide(300);
			},
			change: function (e,ui){
				var current_item_width = $(ui.item).width();
			    $(ui.placeholder).width(current_item_width);
			    $(ui.placeholder).hide().show(300);
			},
			connectWith: '#blocks-to-edit, .column-blocks',
			items: 'li.block',
            cancel: 'ul.block-controls, .modal'
		});
	}

	$('li.block').css('float', 'none');

	resizable_blocks();
	function resizable_blocks() {
		$('ul.blocks li.block').each(function() {
			// The tough loop
			// Set a delay through iteration to ease out the complex assigning of resizable modules giving power to browser to do other things.
			var blockID = $(this).attr('id'),
			blockPar = $(this).parent();

			setTimeout(function(){
				if($("#" + blockID).parents('li').hasClass('mtheme-columns')) {

					$('#' + blockID).resizable(resizable_col_args);

				} else {
					$('#' + blockID).resizable(resizable_args);
				}
				resizable_dynamic_width(blockID);

				// resize trigger
				$('#' + blockID).trigger("resize");
				$('#' + blockID).trigger("resizestop");

				// not resizing now
				$(".ui-resizable.not-resizable").resizable("destroy");
			}, 2000);

		});
	}

	function resizable_certain_block(element) {
			var blockID = $(element).attr('id'),
				blockPar = $(element).parent();

			if( $("#" + blockID).parents('div').hasClass('modal-body') ) {
				// if in modal
			} else {
				if($("#" + blockID).parents('li').hasClass('mtheme-columns')) {
					$('#' + blockID).resizable(resizable_col_args);
				} else {
					$('#' + blockID).resizable(resizable_args);
				}

				resizable_dynamic_width(blockID);

				$('#' + blockID).trigger("resize");
				$('#' + blockID).trigger("resizestop");

				$(".ui-resizable.not-resizable").resizable("destroy");
			}
	}

	$('#blocks-archive').tabs();

	$('#blocks-archive li.block').each(function() {
		$(this).draggable({
			connectToSortable: "#blocks-to-edit",
			helper: 'clone',
			revert: 'invalid',
			disabled: true,
			start: function(event, ui) {
				block_archive = $(this).attr('id');
			}
		});
	});

	$('#blocks-to-edit').sortable({
		placeholder: "placeholder",
		start: function(e, ui){
			var current_item_width = $(ui.item).width();
		    $(ui.placeholder).width(current_item_width);
		    $(ui.placeholder).hide(300);
		},
		change: function (e,ui){
			var current_item_width = $(ui.item).width();
		    $(ui.placeholder).width(current_item_width);
		    $(ui.placeholder).hide().show(300);
		},
		tolerance: "pointer",
		handle: '.block-handle, .block-settings-column',
		connectWith: '#blocks-archive, .column-blocks',
		items: 'li.block',
        cancel: 'ul.block-controls, .modal'
	});

	columns_sortable();

	$( "ul.blocks" ).bind( "sortstart", function(event, ui) {
		ui.placeholder.css('width', ui.helper.css('width'));
		$('.empty-template').fadeOut( "fast", function() {
			// no longer empty builder
			$('.empty-template').fadeOut().remove();
		});

	});

	$( "#blocks-archive .block" ).bind( "mousedown", beforeSortStart);

	function beforeSortStart() {
		undoSave();
	}

	$( "ul.blocks" ).bind( "sortstop", onSortStop);
	function onSortStop(event, ui) {
		ui.item.css({'width':'','height':'','z-index':''});
		if (ui.item.hasClass('ui-draggable')) {
		    ui.item.removeClass('ui-draggable');

		    block_number = makeid();
		    //replace the id
		    ui.item.html(ui.item.html().replace(/<[^<>]+>/g, function(obj) {
		        return obj.replace(/__i__|%i%/g, block_number);
		    }));

		    ui.item.attr("id", block_archive.replace("__i__", block_number));

		    if(ui.item.hasClass('block-em_column_block') ) {
		    	ui.item.addClass('mtheme-columns');
		    	ui.item.find('.clone').first().parent('li').remove();
		    	ui.item.find('.block-settings').removeClass('block-settings').addClass('block-settings-column');
		    }

		    var blockID = ui.item.find('a.block-edit').parents('li').attr('id');
		}

		if(ui.item.hasClass('block-em_column_block') ) {
			if(ui.item.parent().hasClass('column-blocks')) {
				$(this).sortable('cancel');
				return false;
			}
			columns_sortable();
		}

		if(ui.item.parents().hasClass('mtheme-columns')) {

			if ( ui.item.find('.size').length ) {
				var column_span_value = parseInt(ui.item.parents('.mtheme-columns').find('.size').last().val().substring(4));
				var element_span_value = parseInt(ui.item.find('.size').val().substring(4));
				var column_span_class = 'span'+column_span_value;

				if( column_span_value <= element_span_value ) {
					var parent_span = jQuery('.size[name*='+ui.item.parents('.mtheme-columns').attr('id').substring('15')+']').val();

					ui.item.toggleClass (function (index, css) {
					    return (css.match (/\bspan\S+/g) || []).join(' ')+' '+column_span_class;
					});
					ui.item.find('.block-settings').find('.size').val(column_span_class );
				} else {
					ui.item.toggleClass (function (index, css) {
					    return (css.match (/\bspan\S+/g) || []).join(' ')+' '+block_size_incolumn( ui.item.width(),ui.item.parents('.mtheme-columns') );
					});
					ui.item.find('.block-settings').find('.size').val(block_size_incolumn( ui.item.width(), ui.item.parents('.mtheme-columns') ));
				}
				ui.item.css('width', '');
			}
		}
		update_block_order();
		update_block_number();


			var id_name = ui.item[0].id.substring(15);
			$("#aq_block_"+id_name).insertBefore($("#aq_block_"+id_name).parents('.wp-editor-wrap .wp-editor-container > span'));
			$("#aq_block_"+id_name).show().next('.wp-editor-wrap .wp-editor-container > span').remove();

			ui.item.find('input[type="number"]').each(function(index,element) {
				$(this).attr('value',$(element).val());
			});

		    resizable_certain_block(ui.item);
			aqpb_colorpicker();
			$('.current-block-focus').removeClass('current-block-focus');
			ui.item.addClass('current-block-focus').css('width','');
			$('.current-block-focus').addClass( animation_class + ' ' + animation_add );
			setTimeout(function() {
		    	$(document.body).on( 'click', '.insert-media', function( event ) {
		    		if($(this).data('editor') !== 'content')
						wpActiveEditor = $(this).data('editor');
				});
		    },500);

			entityBlockSpan(ui.item.children('div'));

			generatetoolTips();
		}


	/** Template Select **/
	function templateChange() {
	$("#pagebuilderSavedTemplates").change(function() {
		if($("#pagebuilderSavedTemplates option:selected").hasClass('custombuilderblocks')) {
			$.ajax({
				url: global_mtheme.ajax_url,
				type: "POST",
				data : {
					postID : $("#post_ID").val(),
					getTemp : $(this).val(),
					action : 'pagebuilder_get_templates'
				},
				success: function(data) {
					$("#blocks-to-edit").html(data);
					resizable_blocks();
					columns_sortable();
					$( "ul.blocks" ).each(function(index, element) {
						// changed template
					});
				}
			});
		}
		});
		resizable_blocks();
	}
	templateChange();

	$('#page-builder-archive').droppable({
		accept: "#blocks-to-edit .block",
		tolerance: "pointer",
		over : function(event, ui) {
			$(this).find('#removing-block').fadeIn('slow');
			ui.draggable.parent().find('.placeholder').hide();
		},
		out : function(event, ui) {
			$(this).find('#removing-block').fadeOut('Slow');
			ui.draggable.parent().find('.placeholder').show();
		},
		drop: function(ev, ui) {
	        ui.draggable.remove();
	        $(this).find('#removing-block').fadeOut('slow');
		}
	});

	// Click control
	$(document).on('click', '.block-control-actions a', function() {
		$clicked = $(this);
		$parentChild = $(this).parents('li.sortable-item').first();
		$parent = $(this).parents('li.block').first();
		

		// Edit
		if($clicked.hasClass('block-edit')) {
			console.log('Clicked');
		}
		if($clicked.hasClass('delete')) {
			undoSave();
			$parent.find('> .block-bar .block-handle').css('background', '#8c8c8c');
			$parent.fadeOut();
			setTimeout(function() {
				$parent.remove();
				update_block_order();
				update_block_number();
			},500);
			$(this).tooltip('hide');
		} else if($clicked.hasClass('closeTab')) {
			$parent.find('> .block-bar a.block-edit').click();
		} else if($clicked.hasClass('export')) {
			$.ajax({
				url: global_mtheme.ajax_url,
				type: "POST",
				data : {
					exportedData : $clicked.parents('li.block')[0].outerHTML,
					action : 'pagebuilder_export_selected_block'
				},
				success: function(data) {
					$("#exportedBlock").html(data);
				}
			});
 		} else if($clicked.hasClass('clone')) {
			undoSave();
			if($('.current-block-focus').length == 0) {
				$('li.block').last().addClass('current-block-focus');
			}
			if(isNaN($('.current-block-focus').attr('id').substring(15))) {
				var parent_id = $parent.attr('id').substring(15);
			} else {
				var parent_id = parseInt($parent.attr('id').substring(15));
			}

			parent_id_cloned = makeid();
			$parent.find('input:text').each(function() {
			    $(this).attr('value', $(this).val());
			});
			$parent.find('input[type="number"]').each(function() {
				$(this).attr('value',$(this).val());
			});
			$parent.find('input:checkbox').each(function() {
				if($(this).attr('checked')) {
					$(this).attr('checked','checked');
				}
			});
			$parent.find('select').each(function(index,element) {
				$(element).children('option').each(function(indexy,elementy) {
					if($(elementy).val() == $(element).val()) {
						$(elementy).attr('selected','selected');
					}
				});
			});
			$parent.find('textarea').each(function() {
				$(this).text($(this).val());
			});

				var $cloned_element = $parent.clone();
				$('.current-block-focus').removeClass('current-block-focus');
				$cloned_element.addClass('current-block-focus');

				$('.current-block-focus').find('.aq_block_' + parent_id_cloned+'_tabs_editor_tabbed').each(function(index,element) {
				   tinyMCE.execCommand( ' mceRemoveEditor', true, $(element).attr('id'));
			    });
			    setTimeout(function() {
			    	$('.current-block-focus').find('.mce-tinymce').remove();
			    },500);
			    $('.current-block-focus').find('.mce-tinymce').remove();
				$cloned_element.appendTo($parent.parent('ul.blocks'));

			$parent.parent('ul.blocks').children('li').last()[0].outerHTML = pagebuilder_block_clone( $parent.parent('ul.blocks').children('li').last()[0].outerHTML , parent_id , parent_id_cloned);

			$parent.parent('ul.blocks').children('li').last().removeClass('ui-resizable');
			$parent.parent('ul.blocks').children('li').last().find('.ui-resizable-handle').remove();
			resizable_certain_block($('.current-block-focus'));
			$this = $clicked;
			var id_name = parent_id_cloned;
			$("#aq_block_"+id_name).insertBefore($("#aq_block_"+id_name).parents('.wp-editor-wrap .wp-editor-container > span'));
			$("#aq_block_"+id_name).show().next('.wp-editor-wrap .wp-editor-container > span').remove();
			var cloned_number = parseInt($('.current-block-focus').prev().find('.number').val()) + 1;
			$parent.closest('ul.blocks').children('li').last().children('.block-settings').find('.number').val(cloned_number);
			$('li.block').last().find('.order').val($('ul.blocks li.block').length);
			aqpb_colorpicker();
			if($('.current-block-focus').find('.wp-picker-container').find('.wp-picker-container').length !== 0 ) {
				$('.current-block-focus ul li').find('.sortable-body > .wp-picker-container').each(function(index,element) {
					$(element).find('.wp-color-result').first().remove();
				});
				$('.current-block-focus').find('.formview-rightside > .aqpb-color-picker > .wp-picker-container').each(function(index,element) {
					$(element).find('.wp-color-result').first().remove();
				});
			}
			entityBlockSpan($cloned_element.children('div'));
			$('.current-block-focus').addClass(animation_class + ' ' + animation_add );
			generatetoolTips();
			aq_sortable_list_init();
		}
		return false;
	});

	/** There are no templates. So disable **/
	$('#page-builder-column.metabox-holder-disabled').click( function() { return false; });
	$('#page-builder-column.metabox-holder-disabled #blocks-archive .block').draggable("destroy");

	/** Confirm delete **/
	$('a.template-delete').click( function() {
		var agree = confirm('You are about to permanently delete this template. \'Cancel\' to stop, \'OK\' to delete.');
		if(agree) { return } else { return false; }
	});

	/** Save template **/
	$('#save_template_header, #save_template_footer').click(function() {
		var template_name = $('#template-name').val().trim();
		if(template_name.length === 0) {
			$('.major-publishing-actions .open-label').addClass('form-invalid');
			return false;
		}
	});

	$('li.block').css('float', '');

	$('.emptyTemplates').click(function(e) {
		e.preventDefault();
		undoSave();
		$("#blocks-to-edit").html('');
	});
	
	var saveTemplateElement = $('#templateSaver').parent();
	saveTemplateElement.popover({
		html : true
	});
	saveTemplateElement.on('shown.bs.popover', function () {
		saveTemplate();
	});
	saveTemplate();

	function saveTemplate() {
		$('#pagebuildertemplatesave').off('click');
		$('#pagebuildertemplatesave').on('click',function(e) {

			var save_template_button_text = $(this).text();
			$this = $(this);
			e.preventDefault();
			if($('#titleforTemplateStorage').val() == ''){
				$('#titleforTemplateStorage').val(aqjs_script_vars.newtemplate);
			}

			var data_body = $('#aqpb-body');
			var archive_body = $('#blocks-archive');

			archive_body.find('input, select, textarea').not('[type="submit"]').attr("disabled", false);
			data_body.find('input, select, textarea').not('[type="submit"]').attr("disabled", false);

			var datafields,data_keys;
			datafields='';
			data_keys='';

			datafields += '<div id="template-export-temp">';

			$("#blocks-to-edit > li").each(function() {
				var template_id_num = $(this).attr('id');
				var pagedata = $(this).find("select,textarea, input").serialize();
				datafields += '<textarea id="mbuild_data_'+template_id_num+'" style="display:none" name="mbuild_data_'+template_id_num+'">'+ pagedata +'</textarea>';
				data_keys += template_id_num + ',';

			});

			datafields += '<input id="mbuilder_datakeys" style="display:none" name="mbuilder_datakeys" value="'+data_keys+'">';
			datafields += '</div>';
			data_body.after(datafields);

			$.ajax({
				url: global_mtheme.ajax_url,
				type: "POST",
				data: $("#template-export-temp").find("select,textarea, input").serialize() + '&action=pagebuilder_save_templates&saveTempName='+$('#titleforTemplateStorage').val(),
				beforeSend : function() {
					$this.attr('disabled','disabled').text(aqjs_script_vars.saving);
				},
				success: function(data) {
					$('#pagebuilderSavedTemplates').append("<option value='"+data+"' class='custombuilderblocks'>"+data+"</option>");
    				if ($.fn.chosen) {
						$(".chosen-select").trigger("chosen:updated");
					}
					templateChange();
					$('#titleforTemplateStorage').val('');
					$('#templateSaver').parent().popover('hide');
					$('#template-export-temp').remove();
					$this.removeAttr('disabled').text(save_template_button_text);
				},
				complete : function() {
					$this.removeAttr('disabled').text(save_template_button_text);
				},
	            error     : function(jqXHR, textStatus, errorThrown) {
	                alert(jqXHR + " :: " + textStatus + " :: " + errorThrown);
	                $this.removeAttr('disabled').text(save_template_button_text);
	            }
			});
		});

		$('#closepagebuildertemplatesave').click(function(e) {
			e.preventDefault();
			$('#templateSaver').parent().popover('hide');
			//console.log('hola');
		});

	}
	    if ($.fn.chosen) {
	        $('.chosen-select').chosen();
	    }
		$('#mtheme-pb-delete-template button').click(function(e) {
			$this = $(this);
			e.preventDefault();
			if($('#pagebuilderSavedTemplates option:selected').hasClass('custombuilderblocks')) {
				$.ajax({
					url: global_mtheme.ajax_url,
					type: "POST",
					data : {
						getTemp : $('#pagebuilderSavedTemplates').val(),
						action : 'pagebuilder_delete_saved_template'
					},
					success: function(data) {
						$("#blocks-to-edit").html('');
						$('#pagebuilderSavedTemplates option:selected').remove();
						if ($.fn.chosen) {
							$(".chosen-select").trigger("chosen:updated");
						}
					},
					complete : function() {
						$('#mtheme-pb-delete-template').modal('hide');
					}
				});
			} else {
				$('#mtheme-pb-delete-template').modal('hide');
				$('#cantbedeleted').modal('show') 
			}
		});
		$('#retrievePosts').click(function(e) {
			$this = $(this);
			$("#retrieveBuilderTemplate").text(aqjs_script_vars.retrieving);
			var data_body = $('#aqpb-body');
			data_body.find('input, select, textarea').not('[type="submit"]').attr("disabled", false);
			var savedata = $('#aqpb-body').find("select,textarea, input").serialize();

			e.preventDefault();
			$.ajax({
				url: global_mtheme.ajax_url,
				type: "POST",
				data: {
					pageBlocks:  $('#blocks-to-edit').html(),
					action: 'pagebuilder_retrieve_blocks'
				},
				success: function(data) {
					$("#retrieveBuilderTemplate").text(data);
				}
			});
		});

		var importing_ajax_done = false;


		function mtheme_get_pageblocks_data() {

			var datafields_array=[];
			var data_keys;
			var count=0;
			var pagedata;
			var template_id_num;

			data_keys='';

			items = new Array();
			items[0] = new Object();

			$("#blocks-to-edit > li").each(function() {
				template_id_num = $(this).attr('id');
				pagedata = $(this).find("select,textarea, input").serialize();
				datafields_array[template_id_num] =  pagedata;
				items[0][template_id_num] = pagedata;
			});

			return items;
		}


		function mtheme_ready_and_save_builderdata() {

			var check_builder_active;
			check_builder_active = $('#mtheme_pb_isactive').val();

			console.log(check_builder_active);

			var data_body = $('#aqpb-body');
			var archive_body = $('#blocks-archive');

			if (check_builder_active=="1") {
				var num_form_elements = data_body.find('input, select, textarea').not('[type="submit"]').length;
				var num_elements_already_disabled= data_body.find('input:disabled, select:disabled, textarea:disabled').length;
				enabled = (num_form_elements-num_elements_already_disabled);


				archive_body.find('input, select, textarea').not('[type="submit"]').attr("disabled", false);
				data_body.find('input, select, textarea').not('[type="submit"]').attr("disabled", false);

				var datafields,data_keys;
				datafields='';
				data_keys='';

				$("#blocks-to-edit > li").each(function() {
					var template_id_num = $(this).attr('id');
					var pagedata = $(this).find("select,textarea,input").serialize();
					datafields += '<textarea id="mbuild_data_'+template_id_num+'" style="display:none" name="mbuild_data_'+template_id_num+'">'+ pagedata +'</textarea>';
					data_keys += template_id_num + ',';

				});

				archive_body.find('input, select, textarea').not('[type="submit"]').attr("disabled", true);
				data_body.find('input, select, textarea').not('[type="submit"]').attr("disabled", true);
				console.log('data key is:' + data_keys);
				data_body.append('<input id="mbuilder_datakeys" style="display:none" name="mbuilder_datakeys" value="'+data_keys+'">');
				data_body.append(datafields);
			} else {
				// Disable builder data fields - not in builder mode.
				archive_body.find('input, select, textarea').not('[type="submit"]').attr("disabled", true);
				data_body.find('input, select, textarea').not('[type="submit"]').attr("disabled", true);
			}
		}

		$( "#post" ).submit(function( e ) {
			var btnpressed = $(document.activeElement);
			var btnpressID = btnpressed.attr('id');
			console.log( btnpressID );
			if ( btnpressID == "post-preview") {
				console.log('Previewing');
			} else {
				mtheme_ready_and_save_builderdata();
			}
		});

	$("#blocks-archive .ui-tabs-panel li").click(function() {
		block_archive = $(this).attr('id');
		$(this).clone().appendTo($("#blocks-to-edit"));
		$cloned_element = $("#blocks-to-edit > li").last();
		$cloned_element.removeAttr( 'style' );
		$cloned_element.addClass("ui-draggable");

		onSortStop(null, {item: $cloned_element});
		$cloned_element.addClass(animation_class + ' ' + animation_add );
		$('.empty-template').fadeOut( "fast", function() {
			$('.empty-template').fadeOut().remove();
		});
	});

	function blocksizeincr(element,e) {
		e.preventDefault();

		var current_entity = element.parents('li.block');

		if( current_entity.hasClass('mtheme-columns') ) {

			var current_column = element.parents('.mtheme-columns');

			if( current_column.find('.size').last().val() !== current_entity.first().find('.size').val() ) {
				var currentSpan = block_size_incolumn( current_entity.first().width(), current_column );
				var currentSpanNum = parseInt(currentSpan.substring(4)) + 1;
				console.log(currentSpan,currentSpanNum);
				if(currentSpanNum <= 12) {
					current_entity.first().toggleClass( function (index, css) {
						return (css.match (/\bspan\S+/g) || []).join(' ') + ' span' + currentSpanNum;
					});
					current_entity.first().find('.block-settings').find('.size').val('span'+currentSpanNum );
				}
				// set block number
				entityBlockSpan(element);
			}
		}
		else {
			var currentSpan = block_size( current_entity.first().width());
			var currentSpanNum = parseInt(currentSpan.substring(4)) + 1;
				if(currentSpanNum <= 12) {
					current_entity.first().toggleClass( function (index, css) {
						return (css.match (/\bspan\S+/g) || []).join(' ') + ' span' + currentSpanNum;
					});
					current_entity.first().find('.block-settings').find('.size').val('span'+currentSpanNum );
				}
				// set block number
				entityBlockSpan(element);
		}
	}
	function blocksizedecr(element,e) {
		e.preventDefault();

		var current_entity = element.parents('li.block');

		if( current_entity.hasClass('mtheme-columns') ) {
				var currentSpan = block_size_incolumn( current_entity.first().width(), element.parents('.mtheme-columns') );
		} else {
				var currentSpan = block_size( current_entity.first().width() );
		}

		var currentSpanNum = parseInt(currentSpan.substring(4)) - 1;

		console.log(currentSpanNum,currentSpan);
		if(currentSpanNum >= 2) {
			current_entity.first().toggleClass( function (index, css) {
				return (css.match (/\bspan\S+/g) || []).join(' ') + ' span' + currentSpanNum;
			});
			current_entity.first().find('.block-settings').find('.size').val('span'+currentSpanNum );
		}
		// set block number
		entityBlockSpan(element);
	}

	function entityBlockSpan(element) {
		var current_entity = element.parents('li.block');
		if( current_entity.hasClass('mtheme-columns') ) {

			var current_column = element.parents('.mtheme-columns');
			current_column.find('.block-size').first().text(parseInt( current_column.find('.size' ).last().val().substring(4)) + '/12');

			if( current_entity.find('li.block' ).length) {
				current_entity.find('li.block').each(function (count,small_element) {
					$(small_element).find('.block-size').first().text($(small_element).find('.size').last().val().substring(4)+'/12');
				});
			} else {
				current_column.find('.block-size').first().text(parseInt( current_column.find('.size').last().val().substring(4) ) + '/12');
			}
		} else {
			current_entity.find('.block-size').text(parseInt( current_entity.find('.size' ).last().val().substring(4)) + '/12');
		}

	}

		function generatetoolTips() {
			$('a[data-tooltip="tooltip"]').tooltip({
			   animation : 'fade',
			   placement : 'top',
			   container: 'body'
			});
		}

		$('.import-a-block').click(function() {
			$(this).find('div').show();
		});

		$('.templates-export-button').click(function() {
			$('#exportBuilderTemplate').val('');
		});
		// Retrieve Export Templates data
		$('.templates-export-button').click(function() {
			var block_export_button = $('#mtheme-pb-export-templates button');
			var block_export_button_text = $(block_export_button).text();
			$.ajax({
				url: global_mtheme.ajax_url,
				type: "POST",
				data : {
					action : 'pagebuilder_export_templates'
				},
				beforeSend : function() {
					$(block_export_button).attr('disabled','disabled').text('Retrieving...');
				},
				success: function(data) {
					$('#exportBuilderTemplate').val(data);
					$(block_export_button).removeAttr('disabled').text(block_export_button_text);
				},
				complete : function() {
					$(block_export_button).removeAttr('disabled').text(block_export_button_text);
				},
	            error     : function(jqXHR, textStatus, errorThrown) {
	                alert(jqXHR + " :: " + textStatus + " :: " + errorThrown);
	                $(block_export_button).removeAttr('disabled').text(block_export_button_text);
	            }
			});
		});

		$('.templates-import-button').click(function() {
			$('#importdata-error').html('').hide();
		});	
		$('#toggle-preset-buttons').click(function() {
			$('#mtheme-preset-templates').fadeToggle('fast');
			$(this).toggleClass('presets-displayed');
		});
		$('.presetToggle').click(function() {
			$('#mtheme-preset-templates').fadeOut();
			$('#toggle-preset-buttons').toggleClass('presets-displayed');
			$('#preset-template-error').hide();
			var presetName = $(this).parent('.preset-template').data('title');
			var presetSlug = $(this).parent('.preset-template').data('template');
			$('.preset-template-name').text(presetName);
			$('#mtheme-preset-slug').val(presetSlug);
		});
		$('#mtheme-preset-template-confirm button').click(function() {
			var block_import_button = $(this);
			var block_import_button_text = $(block_import_button).text();

			$.ajax({
				url: global_mtheme.ajax_url,
				type: "POST",
				data : {
					templateName : $("#mtheme-preset-slug").val(),
					action : 'builder_import_preset_template'
				},
				beforeSend : function() {
					$(block_import_button).attr('disabled','disabled').html('<i class="fa fa-circle-o-notch fa-spin"></i>');
				},
				success: function(data) {
					importing_ajax_done = true;

					console.log('importing..');
					$(block_import_button).removeAttr('disabled').text(block_import_button_text);

					if( data === undefined || !data || data.length == 0 ) {
						$('#preset-template-error').fadeIn().delay(1000);
					} else {
						$("#blocks-to-edit").html(data);
						pagebuilder_VerifyBlocks();
						update_block_order();
						update_block_number();
						$('ul.blocks li.block.ui-resizable').removeClass('ui-resizable');
						$('ul.blocks li.block .ui-resizable-handle').remove();
						resizable_blocks();
						columns_sortable();
						aq_sortable_list_init();
						aqpb_colorpicker();
						if($('ul.blocks li').find('.wp-picker-container').find('.wp-picker-container').length !== 0 ) {
							$('ul.blocks li ul li').find('.sortable-body > .wp-picker-container').each(function(index,element) {
								$(element).find('.wp-color-result').first().remove();
							});
							$('ul.blocks li').find('.formview-rightside > .aqpb-color-picker > .wp-picker-container').each(function(index,element) {
								$(element).find('.wp-color-result').first().remove();
							});
						}
						$('#mtheme-preset-template-confirm').modal('hide');
					}
				},
				complete : function() {
					$(block_import_button).removeAttr('disabled').text(block_import_button_text);
				},
	            error     : function(jqXHR, textStatus, errorThrown) {
	                alert(jqXHR + " :: " + textStatus + " :: " + errorThrown);
	                $(block_import_button).removeAttr('disabled').text(block_import_button_text);
	            }
			});
		});
		// Import
		$('#mtheme-pb-import-templates button').click(function() {
			var block_import_button = $(this);
			var block_import_button_text = $(block_import_button).text();

			$.ajax({
				url: global_mtheme.ajax_url,
				type: "POST",
				data : {
					importedData : $("#importBuilderTemplate").val(),
					action : 'pagebuilder_import_templates'
				},
				beforeSend : function() {
					$(block_import_button).attr('disabled','disabled').text('Importing...');
				},
				success: function(data) {
					importing_ajax_done = true;

					console.log(data);
					$(block_import_button).removeAttr('disabled').text(block_import_button_text);

					if( data === undefined || !data || data.length == 0 ) {
						$('#importdata-error').html('Import data not vaild!').fadeIn().delay(1000).fadeOut();
					} else {
						$('#pagebuilderSavedTemplates')
							.find('option')
							.remove()
							.end()
							.append(data);
    					if ($.fn.chosen) {
							$(".chosen-select").trigger("chosen:updated");
						}
						$('#mtheme-pb-import-templates').modal('hide');
					}

				},
				complete : function() {
					$('#importBuilderTemplate').val('');
					$(block_import_button).removeAttr('disabled').text(block_import_button_text);
				},
	            error     : function(jqXHR, textStatus, errorThrown) {
	                alert(jqXHR + " :: " + textStatus + " :: " + errorThrown);
	                $(block_import_button).removeAttr('disabled').text(block_import_button_text);
	            }
			});
		});


		$('#import-a-block').click(function() {
			$('#mtheme-pb-import-a-block textarea').val('');
		});
		$('#mtheme-pb-import-a-block button').click(function() {
			var block_import_button = $(this);
			var block_import_button_text = $(block_import_button).text();
			$(this).find('div').show();
			$.ajax({
				url: global_mtheme.ajax_url,
				type: "POST",
				data : {
					importedData : $('#mtheme-pb-import-a-block textarea').val(),
					action : 'pagebuilder_import_selected_block'
				},
				beforeSend : function() {
					$(block_import_button).attr('disabled','disabled').html('<i class="fa fa-circle-o-notch fa-spin"></i>');
				},
				success: function(data) {
					$("#blocks-to-edit").append(data);
					if($('.block').last().find('.id_base').val() == 'em_icon_box')
					{
						$('.block').last().find('.id_base').val('em_features_home');
					}
					pagebuilder_VerifyBlocks();
					update_block_order();
					update_block_number();
					$('ul.blocks li.block.ui-resizable').removeClass('ui-resizable');
					$('ul.blocks li.block .ui-resizable-handle').remove();
					resizable_blocks();
					columns_sortable();
					$('#mtheme-pb-import-a-block textarea').html('');
					$('#mtheme-pb-import-a-block').modal('hide');
					$(block_import_button).removeAttr('disabled').text(block_import_button_text);
				},
				complete : function() {
					$(block_import_button).removeAttr('disabled').text(block_import_button_text);
				},
	            error     : function(jqXHR, textStatus, errorThrown) {
	                alert(jqXHR + " :: " + textStatus + " :: " + errorThrown);
	                $(block_import_button).removeAttr('disabled').text(block_import_button_text);
	            }
			});
		});
		$('#mtheme-pb-live-search').keyup(function(e) {

			var searchingFor = $(this).val();
			
			$("#blocks-archive li.block").hide();
			$("#blocks-archive > .ui-tabs-panel").hide();

			$("#blocks-archive > ul:first-child .ui-state-default").addClass('hide');
			$( ".block-title:contains('"+ searchingFor +"')" ).parents('.block').show().parents('.ui-tabs-panel').show();


			if( searchingFor == '') {
				$("#blocks-archive li.block").show();
				$("#blocks-archive > ul:first-child .ui-state-default").removeClass('hide');
				$("#blocks-archive > ul.ui-tabs-panel").hide();
				$("#blocks-archive > .ui-tabs-panel").first().show();
				$('#blocks-archive > .ui-tabs-nav').css('display','');
			}
		});
		$('#mtheme-icon-live-search').keyup(function(e) {
			console.log(e);
			$( '.icon-filters' ).removeClass( 'filter-is-selected' );
			$(".icon-choosable .fontawesome-icon-wrap").hide();
			$( ".icon-choosable .fontawesome-icon-wrap i[data-icon*='"+$(this).val()+"']").parents('.fontawesome-icon-wrap').show();

			if($(this).val() == '') {
				$(".icon-choosable .fontawesome-icon-wrap").show();
			}
		});

		$('.modal.block-settings').on('shown.bs.modal', function (e) {
			  $('.block-settings .modal-content').bind("keyup keypress", function(e) {
			  	var target = $( e.target );

			  	console.log(target.attr('id'));
				var code = e.keyCode || e.which;
				console.log(e);
				if (code  == 13) {
					if (!target.is("textarea")) {
					    e.preventDefault();
					    return false;
					}
				}
			});
		}).on('hidden.bs.modal', function (e) {
			  $('#post').bind("keyup keypress", function(e) {
			  	return true;
			});
		});

	// icon selector
	$('.mtheme-pb-remove-icon').live('click',function () {
		$(this).parent('.pagebuilder-icon-picker').find('input.mtheme-pb-selected-icon:hidden').val('');
		$(this).parent('.pagebuilder-icon-picker').find('.fontawesome_icon.preview').removeClass().addClass('fontawesome_icon preview');
	});

	function seticonofchoice( that,iconofchoice) {
		that.find( '.icon-choosable' )
		.find( '.iconofchoice' ).removeClass( 'iconofchoice' ).end()
		.find( '.' + ( iconofchoice || 'fontawesome_icon:first' ) ).addClass( 'iconofchoice' );		
	}
	function previewiconofchoice( that,currchoiceicon) {
		that.find('.iconchoice-selected')
		.find( '.fontawesome_icon' ).removeClass().addClass( 'fontawesome_icon ' + currchoiceicon )
		.end().find( '.iconofchoice-title' ).text( currchoiceicon );
	}
	function setnewicon(container,iconofchoice,oldIcon) {
		container.find( '.mtheme-pb-selected-icon' ).val( iconofchoice ).end()
		.find( '.fontawesome_icon.preview' ).removeClass( oldIcon ).addClass( iconofchoice );
	}
	function setdataforSelectednewicon(that,userchoiceicon,userchoiceiconData) {
        if ( userchoiceicon.hasClass( 'iconofchoice' ) ) {
            return;
        }
        that.find('.icon-choosable').find( '.iconofchoice' ).removeClass( 'iconofchoice' );
        userchoiceicon.addClass( 'iconofchoice' );
        that.find( '.iconchoice-selected' ).find( '.fontawesome_icon' ).removeClass().addClass( 'fontawesome_icon ' + userchoiceiconData );
        that.find( '.iconchoice-selected' ).find( '.iconofchoice-title' ).text( userchoiceiconData );
	}
	$('#pagebuilder-icon-picker-modal')
	.on( 'show.bs.modal', function(e) {
	    var _relatedTarget = $(e.relatedTarget), that = $( this );
	    if ( _relatedTarget ) {
	            var container = _relatedTarget.closest( '.pagebuilder-icon-picker' );
	            var oldIcon = container.find( '.mtheme-pb-selected-icon' ).val();

	            var currchoiceicon = that.find( '.icon-choosable .iconofchoice' ).data( 'icon' );

	            seticonofchoice(that,oldIcon);
	            previewiconofchoice(that,currchoiceicon);

	        that.one( 'click', '.pagebuilder-icon-picker-done', function() {
	            var iconofchoice = that.find( '.iconofchoice' ).data( 'icon' );

	            setnewicon(container,iconofchoice,oldIcon);
	            that.modal( 'hide' );
	        } )
	        .one( 'hide', function() {
	            that.off( '.iconselector' );
	        } );
	    }
	    that.on( 'click', '.icon-filters', function() {

	    	var selected_iconspack = $( this ).data( 'iconpack' );
	    	console.log(selected_iconspack);
	    	if (selected_iconspack=="all") {
	    		$( '.icon-filters' ).removeClass( 'filter-is-selected' );
	    		$('.icon-choosable').find('.fontawesome-icon-wrap').show();
	    	} else {
	    		$( '.icon-filters' ).removeClass( 'filter-is-selected' );
	    		$( this ).addClass( 'filter-is-selected' );
		    	$('.icon-choosable').find('.fontawesome-icon-wrap').hide();
		    	$('.icon-choosable').find('.'+selected_iconspack).show();
		    }
	    });
	    that.on( 'click', '.fontawesome_icon', function() {

	    	var userchoiceicon = $(this);
	    	var userchoiceiconData = $( this ).data( 'icon' );
	    	setdataforSelectednewicon(that,userchoiceicon,userchoiceiconData);

	    });
	} );

	function aqpb_colorpicker(where) {
		where = where || '';
		var target = '#page-builder .input-color-picker';
		if (where=='tab') {
			target = '#page-builder .aq-sortable-list .input-color-picker';
		}
		$(target).each(function(){
			var $this	= $(this),
				parent	= $this.parent();
				var color_options = {
				    color: false,
				    mode: 'hsl',
				    controls: {
				        horiz: 's',
				        vert: 'l',
				        strip: 'h'
				    },
				    hide: true,
				    border: true,
				    target: '#wp-color-wrapper',
				    width: 300,
				    palettes: true
				}
				$this.wpColorPicker( color_options );
		});
	}

	aqpb_colorpicker();

	$('ul.blocks').bind('sortstop', function() {
		aqpb_colorpicker();
	});

	// Media Uploader
	var uploadermediaIDs = '.mtheme-gallery-selector-ids';
	var uploadergallery = '.mtheme-gallery-selector-list';
	var uploadereditgallery = 'a.block-edit';
	var uploaderbutton = '.mtheme-gallery-selector';

	var uploaderactiveBlocks;
	var uploaderMediablock;
	var uploaderblocktosee = 'li.block';

		uploaderactiveBlocks = $( 'ul.blocks' );
		uploaderactiveBlocks.on( 'click', uploadereditgallery, function() {
			var $this = $( this ),
				block = $this.closest( uploaderblocktosee );
			uploaderMediablock = {
				block: block,
				edit: $this,
				list: block.find( uploadergallery )
			};
		} );
		mtheme_mediagallery();

	function mtheme_mediagallery() {
		$( document ).on( 'click', uploaderbutton, function(e) {
			e.preventDefault();

			var $this = $( this ),
				idsField = $this.siblings( uploadermediaIDs );
			mtheme_display_gallery( {ids: idsField.val()} )
				.on( 'select update insert', function( selection ) {
					uploaderMediablock.list.empty();
					var attachments = selection.map( function( attachment ) {
						attachment = attachment.toJSON();
						var src = ( attachment.sizes && attachment.sizes['thumbnail'] && attachment.sizes['thumbnail'].url ) || attachment.url;
						//console.log(uploaderMediablock.list);
						uploaderMediablock.list.append( '<li><img src="' + src + '" width="150" height="150"></li>' );
						return attachment;
					} ) || [ ];
					idsField.val( _.pluck( attachments, 'id' ) );
				} )
				.on('open', function() {
					$('#aqpb-body .block-settings.modal.in').hide();
				})
				.on('close', function() {
					$('#aqpb-body .block-settings.modal.in').show();
				})
				.open();
		} );
	}

	function mtheme_display_gallery( options ) {
		var args = _.defaults( options, {
			frame: 'post',
			state: 'gallery-library',
			title: wp.media.view.l10n.editGalleryTitle,
			editing: false,
			library: {type: 'image'},
			multiple: false,
			ids: ''
		} );

		args.selection = ( function( ids, options ) {
			var idsArray = ids.split( ',' ),
				args = {
					orderby: 'post__in',
					order: 'ASC',
					type: 'image',
					perPage: - 1,
					post__in: idsArray
				},
			attachments = wp.media.query( args ),
				selection = new wp.media.model.Selection( attachments.models, {
					props: attachments.props.toJSON(),
					multiple: true
				} );

			if ( options.state == 'gallery-library' && idsArray.length && ! isNaN( parseInt( idsArray[0], 10 ) ) ) {
				options.state = 'gallery-edit';
				options.editing = true;
				options.multiple = true;
			}
			return selection;
		}( args.ids, args ) );

		return wp.media( _.omit( args, 'ids' ) );
	}

	/** Media Uploader */
	$(document).on('click', '.aq_upload_button', function(event) {
		var $clicked = $(this), frame,
			input_id = $clicked.prev().attr('id'),
			media_type = $clicked.attr('rel');

		event.preventDefault();

		if ( frame ) {
			frame.open();
			return;
		}

		frame = wp.media.frames.customHeader = wp.media({
			library: {
				type: media_type
			},
		});

		frame.on( 'select', function() {
			var attachment = frame.state().get('selection').first();
				$('#' + input_id).val(attachment.attributes.url);
				$('#' + input_id).prevAll('.screenshot').attr('src', attachment.attributes.url);
				//console.log(attachment.id);
				$('#' + input_id).prev().val(attachment.id);
		});

		frame.on('open', function() {
			$('#aqpb-body .block-settings.modal.in').hide();
		})
		.on('close', function() {
			$('#aqpb-body .block-settings.modal.in').show();
		})

		frame.open();

	});
	$(document).on('click', '.remove_image', function(event) {
		var $clicked = $(this),
			input_id = $clicked.prev().prev().attr('id');

		event.preventDefault();
		//Clear
		$('#' + input_id).val('');
		$('#' + input_id).prevAll('.screenshot').attr('src', '');
		$('#' + input_id).prev().val('');

	});

	/** Sortable Lists  */
	function aq_sortable_list_add_item(action_id, items) {

		var blockID = items.attr('rel'),
			numArr = items.find('li').map(function(i, e){
				return $(e).attr("rel");
			});

		var maxNum = Math.max.apply(Math, numArr);
		if (maxNum < 1 ) { maxNum = 0};
		var newNum = maxNum + 1;
		var data = {
			action: 'aq_block_'+action_id+'_add_new',
			security: $('#aqpb-nonce').val(),
			count: newNum,
			block_id: blockID
		};
		$.post(ajaxurl, data, function(response) {
			var check = response.charAt(response.length - 1);
			if(check == '-1') {
				alert('An unknown error has occurred');
			} else {
				items.append(response);
				aqpb_colorpicker('tab');
				$('.aq-sortable-add-new').text('Add New');
				$('.aq-sortable-add-new span').remove();
				
				$('#' + blockID + '_tabs-sortable-item-' + newNum ).find('.child-richtext-block').each(function(index,element) {
					richtext_child_id = $(this).attr( 'id' );
					tinyMCE.init({ mode : "none"});
					tinyMCE.execCommand('mceAddEditor', false, richtext_child_id );
				});
			}

		});
	};

	// Init
	function aq_sortable_list_init() {
		$('.modal-body .aq-sortable-list').sortable({
			containment: "parent",
			tolerance: "pointer",
			placeholder: "ui-state-highlight",
			start: function(event, ui) {
				$(this).find('.child-richtext-block').each(function(index,element) {
					richtext_child_id = $(this).attr( 'id' );
					var richtext_value = tinyMCE.get(richtext_child_id).getContent();
					$('#' + richtext_child_id).html(richtext_value);
					tinyMCE.execCommand( 'mceRemoveEditor', true, richtext_child_id );
				});
			},
		    stop: function(event, ui) { 
				$(this).find('.child-richtext-block').each(function(index,element) {
					richtext_child_id = $(this).attr( 'id' );
					tinyMCE.init({ mode : "none"});
					tinyMCE.execCommand('mceAddEditor', false, richtext_child_id );
				});
		    },
			update: function () {
  			}
		});
	}
	aq_sortable_list_init();

	$('ul.blocks').bind('sortstop', function() {
		aq_sortable_list_init();
	});


	$(document).on('click', 'a.aq-sortable-add-new', function() {
		var action_id = $(this).attr('rel'),
			items = $(this).parent().children('ul.aq-sortable-list');
			$(this).text('');
			$(this).append('<span class="fa fa-circle-o-notch fa-spin"></span>');
		aq_sortable_list_add_item(action_id, items);

		$('.modal-body .aq-sortable-list').sortable({
			containment: "parent",
			tolerance: "pointer",
			placeholder: "ui-state-highlight"
		});

		return false;
	});

	// Delete
	$(document).on('click', '.aq-sortable-list a.sortable-delete', function() {
		var $parent = $(this.parentNode.parentNode.parentNode);
		$parent.children('.block-tabs-tab-head').css('background', 'red');
		$parent.slideUp(function() {
			$(this).remove();
		}).fadeOut('fast');
		return false;
	});

	$(document).on('click', '.aq-sortable-list .sortable-out-delete', function() {
		var $parent = $(this.parentNode.parentNode);
		$parent.children('.block-tabs-tab-head').css('background', 'red');
		if($parent.find('.wp-editor-area').attr('id')) {
			tinyMCE.execCommand( 'mceRemoveControl', false, $parent.find('.wp-editor-area').attr('id'));
		}
		$parent.slideUp(function() {
			$(this).remove();
		}).fadeOut('fast');
		return false;
	});

	// Open or close
	$(document).on('click', '.aq-sortable-list .sortable-handle a', function() {
		var $clicked = $(this);

		$clicked.addClass('sortable-clicked');
		$clicked.parents('.aq-sortable-list').find('.sortable-body').each(function(i, el) {
			if($(el).is(':visible') && $(el).prev().find('a').hasClass('sortable-clicked') == false) {
				$(el).slideUp('fast');
			}
		});
		$(this.parentNode.parentNode.parentNode).children('.sortable-body').slideToggle('fast');

		$clicked.removeClass('sortable-clicked');

		return false;
	});

});

/*!
Chosen, a Select Box Enhancer for jQuery and Prototype
by Patrick Filler for Harvest, http://getharvest.com

Version 1.4.2
Full source at https://github.com/harvesthq/chosen
Copyright (c) 2011-2015 Harvest http://getharvest.com

MIT License, https://github.com/harvesthq/chosen/blob/master/LICENSE.md
This file is generated by `grunt build`, do not edit it by hand.
*/

(function() {
  var $, AbstractChosen, Chosen, SelectParser, _ref,
    __hasProp = {}.hasOwnProperty,
    __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

  SelectParser = (function() {
    function SelectParser() {
      this.options_index = 0;
      this.parsed = [];
    }

    SelectParser.prototype.add_node = function(child) {
      if (child.nodeName.toUpperCase() === "OPTGROUP") {
        return this.add_group(child);
      } else {
        return this.add_option(child);
      }
    };

    SelectParser.prototype.add_group = function(group) {
      var group_position, option, _i, _len, _ref, _results;
      group_position = this.parsed.length;
      this.parsed.push({
        array_index: group_position,
        group: true,
        label: this.escapeExpression(group.label),
        title: group.title ? group.title : void 0,
        children: 0,
        disabled: group.disabled,
        classes: group.className
      });
      _ref = group.childNodes;
      _results = [];
      for (_i = 0, _len = _ref.length; _i < _len; _i++) {
        option = _ref[_i];
        _results.push(this.add_option(option, group_position, group.disabled));
      }
      return _results;
    };

    SelectParser.prototype.add_option = function(option, group_position, group_disabled) {
      if (option.nodeName.toUpperCase() === "OPTION") {
        if (option.text !== "") {
          if (group_position != null) {
            this.parsed[group_position].children += 1;
          }
          this.parsed.push({
            array_index: this.parsed.length,
            options_index: this.options_index,
            value: option.value,
            text: option.text,
            html: option.innerHTML,
            title: option.title ? option.title : void 0,
            selected: option.selected,
            disabled: group_disabled === true ? group_disabled : option.disabled,
            group_array_index: group_position,
            group_label: group_position != null ? this.parsed[group_position].label : null,
            classes: option.className,
            style: option.style.cssText
          });
        } else {
          this.parsed.push({
            array_index: this.parsed.length,
            options_index: this.options_index,
            empty: true
          });
        }
        return this.options_index += 1;
      }
    };

    SelectParser.prototype.escapeExpression = function(text) {
      var map, unsafe_chars;
      if ((text == null) || text === false) {
        return "";
      }
      if (!/[\&\<\>\"\'\`]/.test(text)) {
        return text;
      }
      map = {
        "<": "&lt;",
        ">": "&gt;",
        '"': "&quot;",
        "'": "&#x27;",
        "`": "&#x60;"
      };
      unsafe_chars = /&(?!\w+;)|[\<\>\"\'\`]/g;
      return text.replace(unsafe_chars, function(chr) {
        return map[chr] || "&amp;";
      });
    };

    return SelectParser;

  })();

  SelectParser.select_to_array = function(select) {
    var child, parser, _i, _len, _ref;
    parser = new SelectParser();
    _ref = select.childNodes;
    for (_i = 0, _len = _ref.length; _i < _len; _i++) {
      child = _ref[_i];
      parser.add_node(child);
    }
    return parser.parsed;
  };

  AbstractChosen = (function() {
    function AbstractChosen(form_field, options) {
      this.form_field = form_field;
      this.options = options != null ? options : {};
      if (!AbstractChosen.browser_is_supported()) {
        return;
      }
      this.is_multiple = this.form_field.multiple;
      this.set_default_text();
      this.set_default_values();
      this.setup();
      this.set_up_html();
      this.register_observers();
      this.on_ready();
    }

    AbstractChosen.prototype.set_default_values = function() {
      var _this = this;
      this.click_test_action = function(evt) {
        return _this.test_active_click(evt);
      };
      this.activate_action = function(evt) {
        return _this.activate_field(evt);
      };
      this.active_field = false;
      this.mouse_on_container = false;
      this.results_showing = false;
      this.result_highlighted = null;
      this.allow_single_deselect = (this.options.allow_single_deselect != null) && (this.form_field.options[0] != null) && this.form_field.options[0].text === "" ? this.options.allow_single_deselect : false;
      this.disable_search_threshold = this.options.disable_search_threshold || 0;
      this.disable_search = this.options.disable_search || false;
      this.enable_split_word_search = this.options.enable_split_word_search != null ? this.options.enable_split_word_search : true;
      this.group_search = this.options.group_search != null ? this.options.group_search : true;
      this.search_contains = this.options.search_contains || false;
      this.single_backstroke_delete = this.options.single_backstroke_delete != null ? this.options.single_backstroke_delete : true;
      this.max_selected_options = this.options.max_selected_options || Infinity;
      this.inherit_select_classes = this.options.inherit_select_classes || false;
      this.display_selected_options = this.options.display_selected_options != null ? this.options.display_selected_options : true;
      this.display_disabled_options = this.options.display_disabled_options != null ? this.options.display_disabled_options : true;
      return this.include_group_label_in_selected = this.options.include_group_label_in_selected || false;
    };

    AbstractChosen.prototype.set_default_text = function() {
      if (this.form_field.getAttribute("data-placeholder")) {
        this.default_text = this.form_field.getAttribute("data-placeholder");
      } else if (this.is_multiple) {
        this.default_text = this.options.placeholder_text_multiple || this.options.placeholder_text || AbstractChosen.default_multiple_text;
      } else {
        this.default_text = this.options.placeholder_text_single || this.options.placeholder_text || AbstractChosen.default_single_text;
      }
      return this.results_none_found = this.form_field.getAttribute("data-no_results_text") || this.options.no_results_text || AbstractChosen.default_no_result_text;
    };

    AbstractChosen.prototype.choice_label = function(item) {
      if (this.include_group_label_in_selected && (item.group_label != null)) {
        return "<b class='group-name'>" + item.group_label + "</b>" + item.html;
      } else {
        return item.html;
      }
    };

    AbstractChosen.prototype.mouse_enter = function() {
      return this.mouse_on_container = true;
    };

    AbstractChosen.prototype.mouse_leave = function() {
      return this.mouse_on_container = false;
    };

    AbstractChosen.prototype.input_focus = function(evt) {
      var _this = this;
      if (this.is_multiple) {
        if (!this.active_field) {
          return setTimeout((function() {
            return _this.container_mousedown();
          }), 50);
        }
      } else {
        if (!this.active_field) {
          return this.activate_field();
        }
      }
    };

    AbstractChosen.prototype.input_blur = function(evt) {
      var _this = this;
      if (!this.mouse_on_container) {
        this.active_field = false;
        return setTimeout((function() {
          return _this.blur_test();
        }), 100);
      }
    };

    AbstractChosen.prototype.results_option_build = function(options) {
      var content, data, _i, _len, _ref;
      content = '';
      _ref = this.results_data;
      for (_i = 0, _len = _ref.length; _i < _len; _i++) {
        data = _ref[_i];
        if (data.group) {
          content += this.result_add_group(data);
        } else {
          content += this.result_add_option(data);
        }
        if (options != null ? options.first : void 0) {
          if (data.selected && this.is_multiple) {
            this.choice_build(data);
          } else if (data.selected && !this.is_multiple) {
            this.single_set_selected_text(this.choice_label(data));
          }
        }
      }
      return content;
    };

    AbstractChosen.prototype.result_add_option = function(option) {
      var classes, option_el;
      if (!option.search_match) {
        return '';
      }
      if (!this.include_option_in_results(option)) {
        return '';
      }
      classes = [];
      if (!option.disabled && !(option.selected && this.is_multiple)) {
        classes.push("active-result");
      }
      if (option.disabled && !(option.selected && this.is_multiple)) {
        classes.push("disabled-result");
      }
      if (option.selected) {
        classes.push("result-selected");
      }
      if (option.group_array_index != null) {
        classes.push("group-option");
      }
      if (option.classes !== "") {
        classes.push(option.classes);
      }
      option_el = document.createElement("li");
      option_el.className = classes.join(" ");
      option_el.style.cssText = option.style;
      option_el.setAttribute("data-option-array-index", option.array_index);
      option_el.innerHTML = option.search_text;
      if (option.title) {
        option_el.title = option.title;
      }
      return this.outerHTML(option_el);
    };

    AbstractChosen.prototype.result_add_group = function(group) {
      var classes, group_el;
      if (!(group.search_match || group.group_match)) {
        return '';
      }
      if (!(group.active_options > 0)) {
        return '';
      }
      classes = [];
      classes.push("group-result");
      if (group.classes) {
        classes.push(group.classes);
      }
      group_el = document.createElement("li");
      group_el.className = classes.join(" ");
      group_el.innerHTML = group.search_text;
      if (group.title) {
        group_el.title = group.title;
      }
      return this.outerHTML(group_el);
    };

    AbstractChosen.prototype.results_update_field = function() {
      this.set_default_text();
      if (!this.is_multiple) {
        this.results_reset_cleanup();
      }
      this.result_clear_highlight();
      this.results_build();
      if (this.results_showing) {
        return this.winnow_results();
      }
    };

    AbstractChosen.prototype.reset_single_select_options = function() {
      var result, _i, _len, _ref, _results;
      _ref = this.results_data;
      _results = [];
      for (_i = 0, _len = _ref.length; _i < _len; _i++) {
        result = _ref[_i];
        if (result.selected) {
          _results.push(result.selected = false);
        } else {
          _results.push(void 0);
        }
      }
      return _results;
    };

    AbstractChosen.prototype.results_toggle = function() {
      if (this.results_showing) {
        return this.results_hide();
      } else {
        return this.results_show();
      }
    };

    AbstractChosen.prototype.results_search = function(evt) {
      if (this.results_showing) {
        return this.winnow_results();
      } else {
        return this.results_show();
      }
    };

    AbstractChosen.prototype.winnow_results = function() {
      var escapedSearchText, option, regex, results, results_group, searchText, startpos, text, zregex, _i, _len, _ref;
      this.no_results_clear();
      results = 0;
      searchText = this.get_search_text();
      escapedSearchText = searchText.replace(/[-[\]{}()*+?.,\\^$|#\s]/g, "\\$&");
      zregex = new RegExp(escapedSearchText, 'i');
      regex = this.get_search_regex(escapedSearchText);
      _ref = this.results_data;
      for (_i = 0, _len = _ref.length; _i < _len; _i++) {
        option = _ref[_i];
        option.search_match = false;
        results_group = null;
        if (this.include_option_in_results(option)) {
          if (option.group) {
            option.group_match = false;
            option.active_options = 0;
          }
          if ((option.group_array_index != null) && this.results_data[option.group_array_index]) {
            results_group = this.results_data[option.group_array_index];
            if (results_group.active_options === 0 && results_group.search_match) {
              results += 1;
            }
            results_group.active_options += 1;
          }
          option.search_text = option.group ? option.label : option.html;
          if (!(option.group && !this.group_search)) {
            option.search_match = this.search_string_match(option.search_text, regex);
            if (option.search_match && !option.group) {
              results += 1;
            }
            if (option.search_match) {
              if (searchText.length) {
                startpos = option.search_text.search(zregex);
                text = option.search_text.substr(0, startpos + searchText.length) + '</em>' + option.search_text.substr(startpos + searchText.length);
                option.search_text = text.substr(0, startpos) + '<em>' + text.substr(startpos);
              }
              if (results_group != null) {
                results_group.group_match = true;
              }
            } else if ((option.group_array_index != null) && this.results_data[option.group_array_index].search_match) {
              option.search_match = true;
            }
          }
        }
      }
      this.result_clear_highlight();
      if (results < 1 && searchText.length) {
        this.update_results_content("");
        return this.no_results(searchText);
      } else {
        this.update_results_content(this.results_option_build());
        return this.winnow_results_set_highlight();
      }
    };

    AbstractChosen.prototype.get_search_regex = function(escaped_search_string) {
      var regex_anchor;
      regex_anchor = this.search_contains ? "" : "^";
      return new RegExp(regex_anchor + escaped_search_string, 'i');
    };

    AbstractChosen.prototype.search_string_match = function(search_string, regex) {
      var part, parts, _i, _len;
      if (regex.test(search_string)) {
        return true;
      } else if (this.enable_split_word_search && (search_string.indexOf(" ") >= 0 || search_string.indexOf("[") === 0)) {
        parts = search_string.replace(/\[|\]/g, "").split(" ");
        if (parts.length) {
          for (_i = 0, _len = parts.length; _i < _len; _i++) {
            part = parts[_i];
            if (regex.test(part)) {
              return true;
            }
          }
        }
      }
    };

    AbstractChosen.prototype.choices_count = function() {
      var option, _i, _len, _ref;
      if (this.selected_option_count != null) {
        return this.selected_option_count;
      }
      this.selected_option_count = 0;
      _ref = this.form_field.options;
      for (_i = 0, _len = _ref.length; _i < _len; _i++) {
        option = _ref[_i];
        if (option.selected) {
          this.selected_option_count += 1;
        }
      }
      return this.selected_option_count;
    };

    AbstractChosen.prototype.choices_click = function(evt) {
      evt.preventDefault();
      if (!(this.results_showing || this.is_disabled)) {
        return this.results_show();
      }
    };

    AbstractChosen.prototype.keyup_checker = function(evt) {
      var stroke, _ref;
      stroke = (_ref = evt.which) != null ? _ref : evt.keyCode;
      this.search_field_scale();
      switch (stroke) {
        case 8:
          if (this.is_multiple && this.backstroke_length < 1 && this.choices_count() > 0) {
            return this.keydown_backstroke();
          } else if (!this.pending_backstroke) {
            this.result_clear_highlight();
            return this.results_search();
          }
          break;
        case 13:
          evt.preventDefault();
          if (this.results_showing) {
            return this.result_select(evt);
          }
          break;
        case 27:
          if (this.results_showing) {
            this.results_hide();
          }
          return true;
        case 9:
        case 38:
        case 40:
        case 16:
        case 91:
        case 17:
          break;
        default:
          return this.results_search();
      }
    };

    AbstractChosen.prototype.clipboard_event_checker = function(evt) {
      var _this = this;
      return setTimeout((function() {
        return _this.results_search();
      }), 50);
    };

    AbstractChosen.prototype.container_width = function() {
      if (this.options.width != null) {
        return this.options.width;
      } else {
        return "" + this.form_field.offsetWidth + "px";
      }
    };

    AbstractChosen.prototype.include_option_in_results = function(option) {
      if (this.is_multiple && (!this.display_selected_options && option.selected)) {
        return false;
      }
      if (!this.display_disabled_options && option.disabled) {
        return false;
      }
      if (option.empty) {
        return false;
      }
      return true;
    };

    AbstractChosen.prototype.search_results_touchstart = function(evt) {
      this.touch_started = true;
      return this.search_results_mouseover(evt);
    };

    AbstractChosen.prototype.search_results_touchmove = function(evt) {
      this.touch_started = false;
      return this.search_results_mouseout(evt);
    };

    AbstractChosen.prototype.search_results_touchend = function(evt) {
      if (this.touch_started) {
        return this.search_results_mouseup(evt);
      }
    };

    AbstractChosen.prototype.outerHTML = function(element) {
      var tmp;
      if (element.outerHTML) {
        return element.outerHTML;
      }
      tmp = document.createElement("div");
      tmp.appendChild(element);
      return tmp.innerHTML;
    };

    AbstractChosen.browser_is_supported = function() {
      if (window.navigator.appName === "Microsoft Internet Explorer") {
        return document.documentMode >= 8;
      }
      if (/iP(od|hone)/i.test(window.navigator.userAgent)) {
        return false;
      }
      if (/Android/i.test(window.navigator.userAgent)) {
        if (/Mobile/i.test(window.navigator.userAgent)) {
          return false;
        }
      }
      return true;
    };

    AbstractChosen.default_multiple_text = "Select Some Options";

    AbstractChosen.default_single_text = "Select an Option";

    AbstractChosen.default_no_result_text = "No results match";

    return AbstractChosen;

  })();

  $ = jQuery;

  $.fn.extend({
    chosen: function(options) {
      if (!AbstractChosen.browser_is_supported()) {
        return this;
      }
      return this.each(function(input_field) {
        var $this, chosen;
        $this = $(this);
        chosen = $this.data('chosen');
        if (options === 'destroy' && chosen instanceof Chosen) {
          chosen.destroy();
        } else if (!(chosen instanceof Chosen)) {
          $this.data('chosen', new Chosen(this, options));
        }
      });
    }
  });

  Chosen = (function(_super) {
    __extends(Chosen, _super);

    function Chosen() {
      _ref = Chosen.__super__.constructor.apply(this, arguments);
      return _ref;
    }

    Chosen.prototype.setup = function() {
      this.form_field_jq = $(this.form_field);
      this.current_selectedIndex = this.form_field.selectedIndex;
      return this.is_rtl = this.form_field_jq.hasClass("chosen-rtl");
    };

    Chosen.prototype.set_up_html = function() {
      var container_classes, container_props;
      container_classes = ["chosen-container"];
      container_classes.push("chosen-container-" + (this.is_multiple ? "multi" : "single"));
      if (this.inherit_select_classes && this.form_field.className) {
        container_classes.push(this.form_field.className);
      }
      if (this.is_rtl) {
        container_classes.push("chosen-rtl");
      }
      container_props = {
        'class': container_classes.join(' '),
        'style': "width: " + (this.container_width()) + ";",
        'title': this.form_field.title
      };
      if (this.form_field.id.length) {
        container_props.id = this.form_field.id.replace(/[^\w]/g, '_') + "_chosen";
      }
      this.container = $("<div />", container_props);
      if (this.is_multiple) {
        this.container.html('<ul class="chosen-choices"><li class="search-field"><input type="text" value="' + this.default_text + '" class="default" autocomplete="off" /></li></ul><div class="chosen-drop"><ul class="chosen-results"></ul></div>');
      } else {
        this.container.html('<a class="chosen-single chosen-default" tabindex="-1"><span>' + this.default_text + '</span><div><b></b></div></a><div class="chosen-drop"><div class="chosen-search"><input type="text" autocomplete="off" /></div><ul class="chosen-results"></ul></div>');
      }
      this.form_field_jq.hide().after(this.container);
      this.dropdown = this.container.find('div.chosen-drop').first();
      this.search_field = this.container.find('input').first();
      this.search_results = this.container.find('ul.chosen-results').first();
      this.search_field_scale();
      this.search_no_results = this.container.find('li.no-results').first();
      if (this.is_multiple) {
        this.search_choices = this.container.find('ul.chosen-choices').first();
        this.search_container = this.container.find('li.search-field').first();
      } else {
        this.search_container = this.container.find('div.chosen-search').first();
        this.selected_item = this.container.find('.chosen-single').first();
      }
      this.results_build();
      this.set_tab_index();
      return this.set_label_behavior();
    };

    Chosen.prototype.on_ready = function() {
      return this.form_field_jq.trigger("chosen:ready", {
        chosen: this
      });
    };

    Chosen.prototype.register_observers = function() {
      var _this = this;
      this.container.bind('touchstart.chosen', function(evt) {
        _this.container_mousedown(evt);
        return evt.preventDefault();
      });
      this.container.bind('touchend.chosen', function(evt) {
        _this.container_mouseup(evt);
        return evt.preventDefault();
      });
      this.container.bind('mousedown.chosen', function(evt) {
        _this.container_mousedown(evt);
      });
      this.container.bind('mouseup.chosen', function(evt) {
        _this.container_mouseup(evt);
      });
      this.container.bind('mouseenter.chosen', function(evt) {
        _this.mouse_enter(evt);
      });
      this.container.bind('mouseleave.chosen', function(evt) {
        _this.mouse_leave(evt);
      });
      this.search_results.bind('mouseup.chosen', function(evt) {
        _this.search_results_mouseup(evt);
      });
      this.search_results.bind('mouseover.chosen', function(evt) {
        _this.search_results_mouseover(evt);
      });
      this.search_results.bind('mouseout.chosen', function(evt) {
        _this.search_results_mouseout(evt);
      });
      this.search_results.bind('mousewheel.chosen DOMMouseScroll.chosen', function(evt) {
        _this.search_results_mousewheel(evt);
      });
      this.search_results.bind('touchstart.chosen', function(evt) {
        _this.search_results_touchstart(evt);
      });
      this.search_results.bind('touchmove.chosen', function(evt) {
        _this.search_results_touchmove(evt);
      });
      this.search_results.bind('touchend.chosen', function(evt) {
        _this.search_results_touchend(evt);
      });
      this.form_field_jq.bind("chosen:updated.chosen", function(evt) {
        _this.results_update_field(evt);
      });
      this.form_field_jq.bind("chosen:activate.chosen", function(evt) {
        _this.activate_field(evt);
      });
      this.form_field_jq.bind("chosen:open.chosen", function(evt) {
        _this.container_mousedown(evt);
      });
      this.form_field_jq.bind("chosen:close.chosen", function(evt) {
        _this.input_blur(evt);
      });
      this.search_field.bind('blur.chosen', function(evt) {
        _this.input_blur(evt);
      });
      this.search_field.bind('keyup.chosen', function(evt) {
        _this.keyup_checker(evt);
      });
      this.search_field.bind('keydown.chosen', function(evt) {
        _this.keydown_checker(evt);
      });
      this.search_field.bind('focus.chosen', function(evt) {
        _this.input_focus(evt);
      });
      this.search_field.bind('cut.chosen', function(evt) {
        _this.clipboard_event_checker(evt);
      });
      this.search_field.bind('paste.chosen', function(evt) {
        _this.clipboard_event_checker(evt);
      });
      if (this.is_multiple) {
        return this.search_choices.bind('click.chosen', function(evt) {
          _this.choices_click(evt);
        });
      } else {
        return this.container.bind('click.chosen', function(evt) {
          evt.preventDefault();
        });
      }
    };

    Chosen.prototype.destroy = function() {
      $(this.container[0].ownerDocument).unbind("click.chosen", this.click_test_action);
      if (this.search_field[0].tabIndex) {
        this.form_field_jq[0].tabIndex = this.search_field[0].tabIndex;
      }
      this.container.remove();
      this.form_field_jq.removeData('chosen');
      return this.form_field_jq.show();
    };

    Chosen.prototype.search_field_disabled = function() {
      this.is_disabled = this.form_field_jq[0].disabled;
      if (this.is_disabled) {
        this.container.addClass('chosen-disabled');
        this.search_field[0].disabled = true;
        if (!this.is_multiple) {
          this.selected_item.unbind("focus.chosen", this.activate_action);
        }
        return this.close_field();
      } else {
        this.container.removeClass('chosen-disabled');
        this.search_field[0].disabled = false;
        if (!this.is_multiple) {
          return this.selected_item.bind("focus.chosen", this.activate_action);
        }
      }
    };

    Chosen.prototype.container_mousedown = function(evt) {
      if (!this.is_disabled) {
        if (evt && evt.type === "mousedown" && !this.results_showing) {
          evt.preventDefault();
        }
        if (!((evt != null) && ($(evt.target)).hasClass("search-choice-close"))) {
          if (!this.active_field) {
            if (this.is_multiple) {
              this.search_field.val("");
            }
            $(this.container[0].ownerDocument).bind('click.chosen', this.click_test_action);
            this.results_show();
          } else if (!this.is_multiple && evt && (($(evt.target)[0] === this.selected_item[0]) || $(evt.target).parents("a.chosen-single").length)) {
            evt.preventDefault();
            this.results_toggle();
          }
          return this.activate_field();
        }
      }
    };

    Chosen.prototype.container_mouseup = function(evt) {
      if (evt.target.nodeName === "ABBR" && !this.is_disabled) {
        return this.results_reset(evt);
      }
    };

    Chosen.prototype.search_results_mousewheel = function(evt) {
      var delta;
      if (evt.originalEvent) {
        delta = evt.originalEvent.deltaY || -evt.originalEvent.wheelDelta || evt.originalEvent.detail;
      }
      if (delta != null) {
        evt.preventDefault();
        if (evt.type === 'DOMMouseScroll') {
          delta = delta * 40;
        }
        return this.search_results.scrollTop(delta + this.search_results.scrollTop());
      }
    };

    Chosen.prototype.blur_test = function(evt) {
      if (!this.active_field && this.container.hasClass("chosen-container-active")) {
        return this.close_field();
      }
    };

    Chosen.prototype.close_field = function() {
      $(this.container[0].ownerDocument).unbind("click.chosen", this.click_test_action);
      this.active_field = false;
      this.results_hide();
      this.container.removeClass("chosen-container-active");
      this.clear_backstroke();
      this.show_search_field_default();
      return this.search_field_scale();
    };

    Chosen.prototype.activate_field = function() {
      this.container.addClass("chosen-container-active");
      this.active_field = true;
      this.search_field.val(this.search_field.val());
      return this.search_field.focus();
    };

    Chosen.prototype.test_active_click = function(evt) {
      var active_container;
      active_container = $(evt.target).closest('.chosen-container');
      if (active_container.length && this.container[0] === active_container[0]) {
        return this.active_field = true;
      } else {
        return this.close_field();
      }
    };

    Chosen.prototype.results_build = function() {
      this.parsing = true;
      this.selected_option_count = null;
      this.results_data = SelectParser.select_to_array(this.form_field);
      if (this.is_multiple) {
        this.search_choices.find("li.search-choice").remove();
      } else if (!this.is_multiple) {
        this.single_set_selected_text();
        if (this.disable_search || this.form_field.options.length <= this.disable_search_threshold) {
          this.search_field[0].readOnly = true;
          this.container.addClass("chosen-container-single-nosearch");
        } else {
          this.search_field[0].readOnly = false;
          this.container.removeClass("chosen-container-single-nosearch");
        }
      }
      this.update_results_content(this.results_option_build({
        first: true
      }));
      this.search_field_disabled();
      this.show_search_field_default();
      this.search_field_scale();
      return this.parsing = false;
    };

    Chosen.prototype.result_do_highlight = function(el) {
      var high_bottom, high_top, maxHeight, visible_bottom, visible_top;
      if (el.length) {
        this.result_clear_highlight();
        this.result_highlight = el;
        this.result_highlight.addClass("highlighted");
        maxHeight = parseInt(this.search_results.css("maxHeight"), 10);
        visible_top = this.search_results.scrollTop();
        visible_bottom = maxHeight + visible_top;
        high_top = this.result_highlight.position().top + this.search_results.scrollTop();
        high_bottom = high_top + this.result_highlight.outerHeight();
        if (high_bottom >= visible_bottom) {
          return this.search_results.scrollTop((high_bottom - maxHeight) > 0 ? high_bottom - maxHeight : 0);
        } else if (high_top < visible_top) {
          return this.search_results.scrollTop(high_top);
        }
      }
    };

    Chosen.prototype.result_clear_highlight = function() {
      if (this.result_highlight) {
        this.result_highlight.removeClass("highlighted");
      }
      return this.result_highlight = null;
    };

    Chosen.prototype.results_show = function() {
      if (this.is_multiple && this.max_selected_options <= this.choices_count()) {
        this.form_field_jq.trigger("chosen:maxselected", {
          chosen: this
        });
        return false;
      }
      this.container.addClass("chosen-with-drop");
      this.results_showing = true;
      this.search_field.focus();
      this.search_field.val(this.search_field.val());
      this.winnow_results();
      return this.form_field_jq.trigger("chosen:showing_dropdown", {
        chosen: this
      });
    };

    Chosen.prototype.update_results_content = function(content) {
      return this.search_results.html(content);
    };

    Chosen.prototype.results_hide = function() {
      if (this.results_showing) {
        this.result_clear_highlight();
        this.container.removeClass("chosen-with-drop");
        this.form_field_jq.trigger("chosen:hiding_dropdown", {
          chosen: this
        });
      }
      return this.results_showing = false;
    };

    Chosen.prototype.set_tab_index = function(el) {
      var ti;
      if (this.form_field.tabIndex) {
        ti = this.form_field.tabIndex;
        this.form_field.tabIndex = -1;
        return this.search_field[0].tabIndex = ti;
      }
    };

    Chosen.prototype.set_label_behavior = function() {
      var _this = this;
      this.form_field_label = this.form_field_jq.parents("label");
      if (!this.form_field_label.length && this.form_field.id.length) {
        this.form_field_label = $("label[for='" + this.form_field.id + "']");
      }
      if (this.form_field_label.length > 0) {
        return this.form_field_label.bind('click.chosen', function(evt) {
          if (_this.is_multiple) {
            return _this.container_mousedown(evt);
          } else {
            return _this.activate_field();
          }
        });
      }
    };

    Chosen.prototype.show_search_field_default = function() {
      if (this.is_multiple && this.choices_count() < 1 && !this.active_field) {
        this.search_field.val(this.default_text);
        return this.search_field.addClass("default");
      } else {
        this.search_field.val("");
        return this.search_field.removeClass("default");
      }
    };

    Chosen.prototype.search_results_mouseup = function(evt) {
      var target;
      target = $(evt.target).hasClass("active-result") ? $(evt.target) : $(evt.target).parents(".active-result").first();
      if (target.length) {
        this.result_highlight = target;
        this.result_select(evt);
        return this.search_field.focus();
      }
    };

    Chosen.prototype.search_results_mouseover = function(evt) {
      var target;
      target = $(evt.target).hasClass("active-result") ? $(evt.target) : $(evt.target).parents(".active-result").first();
      if (target) {
        return this.result_do_highlight(target);
      }
    };

    Chosen.prototype.search_results_mouseout = function(evt) {
      if ($(evt.target).hasClass("active-result" || $(evt.target).parents('.active-result').first())) {
        return this.result_clear_highlight();
      }
    };

    Chosen.prototype.choice_build = function(item) {
      var choice, close_link,
        _this = this;
      choice = $('<li />', {
        "class": "search-choice"
      }).html("<span>" + (this.choice_label(item)) + "</span>");
      if (item.disabled) {
        choice.addClass('search-choice-disabled');
      } else {
        close_link = $('<a />', {
          "class": 'search-choice-close',
          'data-option-array-index': item.array_index
        });
        close_link.bind('click.chosen', function(evt) {
          return _this.choice_destroy_link_click(evt);
        });
        choice.append(close_link);
      }
      return this.search_container.before(choice);
    };

    Chosen.prototype.choice_destroy_link_click = function(evt) {
      evt.preventDefault();
      evt.stopPropagation();
      if (!this.is_disabled) {
        return this.choice_destroy($(evt.target));
      }
    };

    Chosen.prototype.choice_destroy = function(link) {
      if (this.result_deselect(link[0].getAttribute("data-option-array-index"))) {
        this.show_search_field_default();
        if (this.is_multiple && this.choices_count() > 0 && this.search_field.val().length < 1) {
          this.results_hide();
        }
        link.parents('li').first().remove();
        return this.search_field_scale();
      }
    };

    Chosen.prototype.results_reset = function() {
      this.reset_single_select_options();
      this.form_field.options[0].selected = true;
      this.single_set_selected_text();
      this.show_search_field_default();
      this.results_reset_cleanup();
      this.form_field_jq.trigger("change");
      if (this.active_field) {
        return this.results_hide();
      }
    };

    Chosen.prototype.results_reset_cleanup = function() {
      this.current_selectedIndex = this.form_field.selectedIndex;
      return this.selected_item.find("abbr").remove();
    };

    Chosen.prototype.result_select = function(evt) {
      var high, item;
      if (this.result_highlight) {
        high = this.result_highlight;
        this.result_clear_highlight();
        if (this.is_multiple && this.max_selected_options <= this.choices_count()) {
          this.form_field_jq.trigger("chosen:maxselected", {
            chosen: this
          });
          return false;
        }
        if (this.is_multiple) {
          high.removeClass("active-result");
        } else {
          this.reset_single_select_options();
        }
        high.addClass("result-selected");
        item = this.results_data[high[0].getAttribute("data-option-array-index")];
        item.selected = true;
        this.form_field.options[item.options_index].selected = true;
        this.selected_option_count = null;
        if (this.is_multiple) {
          this.choice_build(item);
        } else {
          this.single_set_selected_text(this.choice_label(item));
        }
        if (!((evt.metaKey || evt.ctrlKey) && this.is_multiple)) {
          this.results_hide();
        }
        this.search_field.val("");
        if (this.is_multiple || this.form_field.selectedIndex !== this.current_selectedIndex) {
          this.form_field_jq.trigger("change", {
            'selected': this.form_field.options[item.options_index].value
          });
        }
        this.current_selectedIndex = this.form_field.selectedIndex;
        evt.preventDefault();
        return this.search_field_scale();
      }
    };

    Chosen.prototype.single_set_selected_text = function(text) {
      if (text == null) {
        text = this.default_text;
      }
      if (text === this.default_text) {
        this.selected_item.addClass("chosen-default");
      } else {
        this.single_deselect_control_build();
        this.selected_item.removeClass("chosen-default");
      }
      return this.selected_item.find("span").html(text);
    };

    Chosen.prototype.result_deselect = function(pos) {
      var result_data;
      result_data = this.results_data[pos];
      if (!this.form_field.options[result_data.options_index].disabled) {
        result_data.selected = false;
        this.form_field.options[result_data.options_index].selected = false;
        this.selected_option_count = null;
        this.result_clear_highlight();
        if (this.results_showing) {
          this.winnow_results();
        }
        this.form_field_jq.trigger("change", {
          deselected: this.form_field.options[result_data.options_index].value
        });
        this.search_field_scale();
        return true;
      } else {
        return false;
      }
    };

    Chosen.prototype.single_deselect_control_build = function() {
      if (!this.allow_single_deselect) {
        return;
      }
      if (!this.selected_item.find("abbr").length) {
        this.selected_item.find("span").first().after("<abbr class=\"search-choice-close\"></abbr>");
      }
      return this.selected_item.addClass("chosen-single-with-deselect");
    };

    Chosen.prototype.get_search_text = function() {
      return $('<div/>').text($.trim(this.search_field.val())).html();
    };

    Chosen.prototype.winnow_results_set_highlight = function() {
      var do_high, selected_results;
      selected_results = !this.is_multiple ? this.search_results.find(".result-selected.active-result") : [];
      do_high = selected_results.length ? selected_results.first() : this.search_results.find(".active-result").first();
      if (do_high != null) {
        return this.result_do_highlight(do_high);
      }
    };

    Chosen.prototype.no_results = function(terms) {
      var no_results_html;
      no_results_html = $('<li class="no-results">' + this.results_none_found + ' "<span></span>"</li>');
      no_results_html.find("span").first().html(terms);
      this.search_results.append(no_results_html);
      return this.form_field_jq.trigger("chosen:no_results", {
        chosen: this
      });
    };

    Chosen.prototype.no_results_clear = function() {
      return this.search_results.find(".no-results").remove();
    };

    Chosen.prototype.keydown_arrow = function() {
      var next_sib;
      if (this.results_showing && this.result_highlight) {
        next_sib = this.result_highlight.nextAll("li.active-result").first();
        if (next_sib) {
          return this.result_do_highlight(next_sib);
        }
      } else {
        return this.results_show();
      }
    };

    Chosen.prototype.keyup_arrow = function() {
      var prev_sibs;
      if (!this.results_showing && !this.is_multiple) {
        return this.results_show();
      } else if (this.result_highlight) {
        prev_sibs = this.result_highlight.prevAll("li.active-result");
        if (prev_sibs.length) {
          return this.result_do_highlight(prev_sibs.first());
        } else {
          if (this.choices_count() > 0) {
            this.results_hide();
          }
          return this.result_clear_highlight();
        }
      }
    };

    Chosen.prototype.keydown_backstroke = function() {
      var next_available_destroy;
      if (this.pending_backstroke) {
        this.choice_destroy(this.pending_backstroke.find("a").first());
        return this.clear_backstroke();
      } else {
        next_available_destroy = this.search_container.siblings("li.search-choice").last();
        if (next_available_destroy.length && !next_available_destroy.hasClass("search-choice-disabled")) {
          this.pending_backstroke = next_available_destroy;
          if (this.single_backstroke_delete) {
            return this.keydown_backstroke();
          } else {
            return this.pending_backstroke.addClass("search-choice-focus");
          }
        }
      }
    };

    Chosen.prototype.clear_backstroke = function() {
      if (this.pending_backstroke) {
        this.pending_backstroke.removeClass("search-choice-focus");
      }
      return this.pending_backstroke = null;
    };

    Chosen.prototype.keydown_checker = function(evt) {
      var stroke, _ref1;
      stroke = (_ref1 = evt.which) != null ? _ref1 : evt.keyCode;
      this.search_field_scale();
      if (stroke !== 8 && this.pending_backstroke) {
        this.clear_backstroke();
      }
      switch (stroke) {
        case 8:
          this.backstroke_length = this.search_field.val().length;
          break;
        case 9:
          if (this.results_showing && !this.is_multiple) {
            this.result_select(evt);
          }
          this.mouse_on_container = false;
          break;
        case 13:
          if (this.results_showing) {
            evt.preventDefault();
          }
          break;
        case 32:
          if (this.disable_search) {
            evt.preventDefault();
          }
          break;
        case 38:
          evt.preventDefault();
          this.keyup_arrow();
          break;
        case 40:
          evt.preventDefault();
          this.keydown_arrow();
          break;
      }
    };

    Chosen.prototype.search_field_scale = function() {
      var div, f_width, h, style, style_block, styles, w, _i, _len;
      if (this.is_multiple) {
        h = 0;
        w = 0;
        style_block = "position:absolute; left: -1000px; top: -1000px; display:none;";
        styles = ['font-size', 'font-style', 'font-weight', 'font-family', 'line-height', 'text-transform', 'letter-spacing'];
        for (_i = 0, _len = styles.length; _i < _len; _i++) {
          style = styles[_i];
          style_block += style + ":" + this.search_field.css(style) + ";";
        }
        div = $('<div />', {
          'style': style_block
        });
        div.text(this.search_field.val());
        $('body').append(div);
        w = div.width() + 25;
        div.remove();
        f_width = this.container.outerWidth();
        if (w > f_width - 10) {
          w = f_width - 10;
        }
        return this.search_field.css({
          'width': w + 'px'
        });
      }
    };

    return Chosen;

  })(AbstractChosen);

}).call(this);