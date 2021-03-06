<?php require_once(dirname(__FILE__).'/js/item-js.php'); ?>
<?php require_once(dirname(__FILE__).'../../../helpers/view_helper.php'); ?>
<?php $post = get_post($collection_id); ?>
<?php $ranking = (get_post_meta($collection_id, 'socialdb_collection_ranking_default_id', true)) ? get_post_meta($collection_id, 'socialdb_collection_ranking_default_id', true) : get_term_by('name', __('In favor / Against', 'tainacan'),'socialdb_property_type')->term_id; ?>
<?php $view_helper = new ViewHelperContest; ?>
<?php 
    $temp = $object;
    while($temp->post_parent!==0){
        $temp = get_post($temp->post_parent);
        $parents[] = $temp;
    }
    $_special_configs = [
        'info_messages' => ( (isset($_GET['info_messages'])) ? trim($_GET['info_messages']) : ''),
        'item' => ( (isset($_GET['item'])) ? trim($_GET['item']) : ''),
        'category' => ( (isset($_GET['category'])) ? trim($_GET['category']) : ''),
        'property' => ( (isset($_GET['property'])) ? trim($_GET['property']) : ''),
        'tag' => ( (isset($_GET['tag'])) ? trim($_GET['tag']) : ''),
        'tax' => ( (isset($_GET['tax'])) ? trim($_GET['tax']) : '')
    ];
?>

<input type="hidden" id="info_messages" name="info_messages" value="<?php echo $_special_configs['info_messages']; ?>" />
<!-- PAGINA DA CATEGORIA -->
<input type="hidden" id="category_page" name="category_page" value="<?php echo $_special_configs['category']; ?>" />
<!-- PAGINA DA PROPRIEDADE -->
<input type="hidden" id="property_page" name="property_page" value="<?php echo $_special_configs['property']; ?>" />
<!-- PAGINA DA TAG -->
<input type="hidden" id="tag_page" name="tag_page" value="<?php echo $_special_configs['tag']; ?>" />
<!-- PAGINA DA TAXONOMIA -->
<input type="hidden" id="tax_page" name="tax_page" value="<?php echo $_special_configs['tax']; ?>" />
<input type="hidden" id="src" value="<?php echo get_template_directory_uri() ?>">
<input type="hidden" id="current_user_id" name="current_user_id" value="<?php echo get_current_user_id(); ?>" />
<input type="hidden" id="collection_id" value="<?php echo $collection_id ?>">
<input type="hidden" id="item_id" value="<?php echo $object->ID; ?>">
<input type="hidden" id="ranking_id" value="<?php echo $ranking; ?>">
<input type="hidden" id="socialdb_permalink_object" name="socialdb_permalink_object" value="<?php echo get_the_permalink($collection_id) . '?item=' . $object->post_name; ?>" />
<input type="hidden" id="related-id" value="<?php echo get_post_meta($post->ID, 'socialdb_collection_property_related_id', TRUE); ?>">
<input type="hidden" id="single_name" name="item_single_name" value="<?php echo $object->post_name; ?>" />
<input type="hidden" id="url-argument" value="<?php echo htmlentities(get_permalink(get_option('collection_root_id')).'?item='.$object->post_name); ?>">
<div class="chatContainer">
    <ol class="breadcrumb item-breadcrumbs breadcrumbs-debate" style="padding-top: 10px;">
        <li> <a href="<?php echo get_permalink(get_option('collection_root_id')); ?>"> <?php _e('Repository', 'tainacan') ?> </a> </li>
        <li> <a href="<?php echo get_the_permalink($collection_id) ?>" > <?php echo $post->post_title; ?> </a> </li>
        <?php 
           $parents = (isset($parents) && is_array($parents)) ? array_reverse($parents) : [];
           foreach ($parents as $parent) {
               ?>
                <li> <a href="#" onclick="showSingleObject('<?php echo $parent->ID; ?>', $('#src').val())" > <?php echo $parent->post_title; ?> </a> </li>
               <?php
           }
        ?>
        <li class="active"> 
            <?php echo (strlen($object->post_title) > 40 ) ?  substr($object->post_title, 0, 40).'...' : $object->post_title; ?> 
        </li>
    </ol>
    <br>
    <div class="chatHistoryContainer">

        <ul class="formComments">
            <li class="commentLi commentstep-1" data-commentid="<?php echo $object->ID; ?>">
                <table class="form-comments-table">
                    <tr>
                        <td class="row">
                            <div class="col-md-1 no-padding user-thumb-container">
                                <div class="comment-avatar">
                                    <?php echo get_avatar($object->post_author) ?>
                                </div>    
                            </div>
                            <div class="col-md-11 no-padding" style="line-height: 0.9;">
                                <p><b><?php echo get_user_by('id', $object->post_author)->display_name ?></b></p>
                                <?php echo $object->post_date_gmt ?>
                            </div>
                            <div class="col-md-12">
                                 <div id="comment-<?php echo $object->ID; ?>" 
                                     data-commentid="<?php echo $object->ID; ?>" 
                                     class="comment comment-step1">
                                     <span id="text-comment-<?php echo $object->ID; ?>"><?php echo $object->post_title; ?></span>
                                 </div>     
                            </div>
                            <div class="col-md-12 argument-operation">
                                <div class="score col-md-1 no-padding">
                                    <span  onclick="contest_save_vote_binary_up('<?php echo $ranking; ?>', '<?php echo $object->ID; ?>')" >
                                        <span class="glyphicon glyphicon-thumbs-up"></span>
                                        <span id="constest_score_<?php echo $object->ID; ?>_up">
                                            <?php echo $view_helper->get_counter_ranking($ranking, $object->ID,'count_up') ?>
                                        </span>
                                    </span>
                                    &nbsp;&nbsp;
                                    <span  onclick="contest_save_vote_binary_down('<?php echo $ranking; ?>', '<?php echo $object->ID; ?>')">
                                        <span class="glyphicon glyphicon-thumbs-down"></span>
                                        <span id="constest_score_<?php echo $object->ID; ?>_down">
                                            <?php echo $view_helper->get_counter_ranking($ranking, $object->ID,'count_down') ?>
                                        </span>
                                    </span>    
                                </div>
                                <div class="argument-operation-links  col-md-11 no-padding">
                                    <span class="pull-left">
                                        <a href="javascript:void(0)" onclick="open_positive_argument('<?php echo $object->ID; ?>')"><?php _e('Favorable argument','tainacan') ?></a>
                                        &nbsp;&nbsp;
                                        <a href="javascript:void(0)" onclick="open_negative_argument('<?php echo $object->ID; ?>')"><?php _e('Counter argument','tainacan') ?></a>
                                    </span>
                                    <span class="link-center" >
                                        <a href="javascript:void(0)" 
                                           onclick="open_properties_argument(<?php echo $object->ID; ?>)"
                                           id="open_properties_argument_<?php echo $object->ID; ?>">
                                            <span class="glyphicon glyphicon-chevron-down"/><?php _e('More information','tainacan') ?>
                                        </a>
                                        <a href="javascript:void(0)" 
                                           onclick="hide_properties_argument(<?php echo $object->ID; ?>)"
                                           id="hide_properties_argument_<?php echo $object->ID; ?>"
                                           style="display:none;"><span class="glyphicon glyphicon-chevron-up"/><?php _e('Hide information','tainacan') ?></a>
                                    </span>  
                                    <span class="pull-right">
                                        <ul class="nav navbar-bar navbar-right item-menu-container" style="margin-top: -15px;">
                                            <li class="dropdown open_item_actions" id="action-<?php echo $object->ID;; ?>">
                                                <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                                    <?php echo ViewHelper::render_icon("config", "png", _t('Item options')); ?>
                                                </a>
                                                <ul class="dropdown-menu pull-right dropdown-show new-item-menu" role="menu" id="item-menu-options">    
                                                    <?php if($object->post_author   ==  get_current_user_id()): ?>
                                                        <li style="margin-bottom: 0px;" class="tainacan-museum-clear"><a href="javascript:void(0)" onclick="edit_comment( '<?php echo $object->ID; ?>')">
                                                               <span class="glyphicon glyphicon-edit"></span>&nbsp;<?php _e('Edit','tainacan') ?>
                                                            </a>
                                                        </li>
                                                        <li style="margin-bottom: 0px;" class="tainacan-museum-clear">
                                                            <a href="javascript:void(0)" onclick="delete_comment('<?php echo $object->ID; ?>')">
                                                                <span class="glyphicon glyphicon-trash"></span>&nbsp;<?php _e('Remove','tainacan') ?>
                                                            </a>
                                                        </li>
                                                    <?php else: ?>
                                                        <li style="margin-bottom: 0px;" class="tainacan-museum-clear">
                                                            <a href="javascript:void(0)"   onclick="report_abuse('<?php echo $child->ID; ?>') ">
                                                                <span class="glyphicon glyphicon-alert"></span>&nbsp;<?php _e('Report abuse','tainacan') ?>
                                                            </a>
                                                        </li>
                                                     <?php endif; ?>   
                                                        <li  style="margin-bottom: 0px;width: 200px;" class="item-redesocial">
                                                            <a href="javascript:void(0)" 
                                                                            onclick="share_comment( '<?php echo $object->ID; ?>','<?php  echo htmlentities($object->post_title) ?>',$('#url-argument').val())" >
                                                                <span class="glyphicon glyphicon-share"></span>&nbsp;<?php _e('Share','tainacan') ?>
                                                            </a>
                                                        </li>
                                                </ul>
                                            </li>
                                        </ul>    
                                    </span>
                                </div>
                            </div>
                            <div style="display:none" class='col-md-12 positive-argument' id='positive-argument-<?php echo $object->ID; ?>'>
                                <form class="form_positive_argument">
                                    <input type="hidden" id="collection_postive_argument_id" name="collection_id" value="<?php echo $collection_id; ?>">
                                    <input type="hidden" name="classifications" value="">
                                    <input type="hidden" name="root_argument" value="<?php echo $object->ID; ?>">
                                    <input type="hidden" name="argument_parent" value="<?php echo $object->ID; ?>">
                                    <input type="hidden" name="operation" value="add_reply_positive">
                                    <span class="col-md-1 no-padding user-thumb-container">
                                        <img src="<?php echo get_template_directory_uri() ?>/modules/<?php echo MODULE_CONTEST ?>/libraries/images/smile-face.png">
                                    </span>
                                    <div class="col-md-1 no-padding user-thumb-container">
                                        <div class="comment-avatar">
                                            <?php echo get_avatar(get_current_user_id()) ?>
                                        </div>    
                                    </div>
                                    <div class="col-md-8 text-area-container">
                                        <textarea rows="4" class="form-control positive_argument" name="positive_argument"></textarea>
                                    </div>
                                    <div class="col-md-2 no-padding">
                                        <span 
                                            style="cursor: pointer;"
                                            onclick="$('#positive-argument-<?php echo $object->ID; ?>').fadeOut()" 
                                            class="pull-right glyphicon glyphicon-remove"></span>
                                        <br><br><br>
                                        <button type="submit" class="btn btn-primary btn-block"><?php _e('Send','tainacan') ?></button>
                                    </div>
                                </form>    
                            </div>
                            <div  style="display:none" class='col-md-12 negative-argument' id='negative-argument-<?php echo $object->ID; ?>'>
                                <form class="form_negative_argument">
                                    <input type="hidden" name="collection_id" value="<?php echo $collection_id; ?>">
                                    <input type="hidden" name="classifications" value="">
                                    <input type="hidden" name="root_argument" value="<?php echo $object->ID; ?>">
                                    <input type="hidden" name="argument_parent" value="<?php echo $object->ID; ?>">
                                    <input type="hidden" name="operation" value="add_reply_negative">
                                    <span class="col-md-1 no-padding user-thumb-container">
                                        <img src="<?php echo get_template_directory_uri() ?>/modules/<?php echo MODULE_CONTEST ?>/libraries/images/rage-face.png">
                                    </span>
                                    <div class="col-md-1 no-padding user-thumb-container">
                                        <div class="comment-avatar">
                                            <?php echo get_avatar(get_current_user_id()) ?>
                                        </div>    
                                    </div>
                                    <div class="col-md-8 text-area-container">
                                        <textarea rows="4" class="form-control negative_argument" name="negative_argument" ></textarea>
                                    </div>
                                    <div  class="col-md-2 no-padding">
                                        <span 
                                            style="cursor: pointer;"
                                            onclick="$('#negative-argument-<?php echo $object->ID; ?>').fadeOut()" 
                                            class="pull-right glyphicon glyphicon-remove"></span>
                                        <br><br><br>
                                        <button type="submit" class="btn btn-primary btn-block"><?php _e('Send','tainacan') ?></button>
                                    </div>
                                </form>    
                            </div>
                            <div style="display:none" class='col-md-12' id='properties-argument-<?php echo $object->ID; ?>'></div>
                            <!--
                            <div class="col-md-12">
                                <div class="comment-timestamp"><?php echo $object->post_date_gmt ?></div>
                                <div class="comment-user">
                                    <?php echo get_user_by('id', $object->post_author)->display_name ?>
                                </div>
                                <div id="comment-<?php echo $object->ID; ?>" 
                                     data-commentid="<?php echo $object->ID; ?>" 
                                     class="comment comment-step1">
                                    <h5>
                                        <span class="label label-info">
                                            <span id="constest_score_<?php echo $object->ID; ?>"><?php echo $view_helper->get_counter_ranking($ranking, $object->ID) ?></span>
                                        </span>   
                                    &nbsp;<span id='popover_positive_<?php echo $object->ID; ?>'></span><span id='popover_negative_<?php echo $object->ID; ?>'></span><b id="text-comment-<?php echo $object->ID; ?>"><?php echo $object->post_title; ?></b>
                                    </h5>    
                                    <div id="commentactions-<?php echo $object->ID; ?>" class="comment-actions">
                                        <div class="btn-group" role="group" aria-label="...">
                                            <button type="button" 
                                                    onclick="contest_save_vote_binary_up('<?php echo $ranking; ?>', '<?php echo $object->ID; ?>')" 
                                                    class="btn btn-success btn-sm">
                                                <span class="glyphicon glyphicon-menu-up"></span>
                                            </button>
                                            <button type="button" onclick="contest_save_vote_binary_down('<?php echo $ranking; ?>', '<?php echo $object->ID; ?>')" class="btn btn-danger btn-sm">
                                                <span class="glyphicon glyphicon-menu-down"></span>
                                            </button>
                                        </div>                                
                                        <div class="btn-group" role="group" aria-label="...">
                                            <!--button type="button" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-comment"></span> <?php _e('Reply','tainacan') ?></button>
                                            <?php if($object->post_author   ==  get_current_user_id()): ?>
                                            <button type="button" 
                                                    onclick="edit_comment( '<?php echo $object->ID; ?>')" 
                                                    class="btn btn-default btn-sm">
                                                <span class="glyphicon glyphicon-edit"></span> <?php _e('Edit','tainacan') ?>
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash"></span> <?php _e('Remove','tainacan') ?></button>
                                            <?php else: ?>
                                            <button type="button" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-alert"></span><?php _e('Report abuse','tainacan') ?></button>
                                            <?php endif; ?>   
                                            <button type="button" 
                                                    onclick="share_comment( '<?php echo $object->ID; ?>','<?php  echo htmlentities($object->post_title) ?>',$('#url-argument').val())" 
                                                    class="btn btn-default btn-sm">
                                                <span class="glyphicon glyphicon-share"></span><?php _e('Share','tainacan') ?>
                                            </button>
                                        </div>    
                                    </div>
                                </div>     
                            </div> 
                            -->
                        </td>
                    </tr>
                </table>
            </li>  
            <?php
                $view_helper->getChildrenItems($ranking,$object->ID, 2,$collection_id,$object->ID);
            ?>
        </ul>
    </div>
</div>
<?php include_once 'modals.php'; ?>
<script>
    var rootComment = '<?php echo $object->ID; ?>';
    $(document).ready(function () {

        initUIEvents();      
        
    });
    
    function initUIEvents() {

        $(".comment").unbind().click(function () {

            var currentComment = $(this).data("commentid");

            //$("#commentactions-" + currentComment).slideDown("fast");

        });


        $(".commentLi").hover(function () {

            var currentComment = $(this).data("commentid");
            $("#commentactions-" + currentComment).slideDown("fast");    
            //$("#comment-" + currentComment).stop().animate({opacity: "1", backgroundColor: "#f8f8f8", borderLeftWidth: "4px"}, {duration: 100, complete: function () {}});

        }, function () {

            var currentComment = $(this).data("commentid");

            //$("#comment-" + currentComment).stop().animate({opacity: "1", backgroundColor: "#fff", borderLeftWidth: "1px"}, {duration: 100, complete: function () {}});

            $("#commentactions-" + currentComment).slideUp("fast");

        });

    }
</script>    

