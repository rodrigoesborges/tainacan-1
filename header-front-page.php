<?php 
$options = get_option('socialdb_theme_options');
$collection_default = get_option('disable_empty_collection');
?>
<!-- TAINACAN: hiddeNs responsaveis em realizar acoes do repositorio -->
<input type="hidden" id="show_collection_default" name="show_collection_default" value="<?php echo (!$collection_default || $collection_default === 'false') ? 'show' : 'hide'; ?>">
<input type="hidden" id="src" name="src" value="<?php echo get_template_directory_uri() ?>">
<input type="hidden" id="repository_main_page" name="repository_main_page" value="true">
<input type="hidden" id="collection_root_url" value="<?php echo get_the_permalink(get_option('collection_root_id')) ?>">
<input type="hidden" id="info_messages" name="info_messages" value="<?php
if (isset($_GET['info_messages'])) {
    echo $_GET['info_messages'];
}
?>">
 <!-- PAGINA DO ITEM -->
    <input type="hidden" id="object_page" name="object_page" value="<?php
    if (isset($_GET['item'])) {
        echo trim($_GET['item']);
    }
    ?>">
    <!-- PAGINA DA CATEGORIA -->
    <input type="hidden" id="category_page" name="category_page" value="<?php
    if (isset($_GET['category'])) {
        echo trim($_GET['category']);
    }
    ?>">
    <!-- PAGINA DA PROPRIEDADE -->
    <input type="hidden" id="property_page" name="property_page" value="<?php
    if (isset($_GET['category'])) {
        echo trim($_GET['category']);
    }
    ?>">
    <!-- PAGINA DA TAG -->
    <input type="hidden" id="tag_page" name="tag_page" value="<?php
    if (isset($_GET['tag'])) {
        echo trim($_GET['tag']);
    }
    ?>">
    <!-- PAGINA DA TAXONOMIA -->
    <input type="hidden" id="tax_page" name="object_page" value="<?php
    if (isset($_GET['tax'])) {
        echo trim($_GET['tax']);
    }
    ?>">
<input type="hidden" id="socialdb_fb_api_id" name="socialdb_fb_api_id" value="<?php echo $options['socialdb_fb_api_id']; ?>">
<input type="hidden" id="socialdb_embed_api_id" name="socialdb_embed_api_id" value="<?php echo $options['socialdb_embed_api_id']; ?>">
<input type="hidden" id="collection_id" name="collection_id" value="<?php echo get_option('collection_root_id'); ?>">
<div id="main_part" class="home">
    <?php if(has_action('alter_home_page')): ?>
        <?php do_action('alter_home_page') ?>
    <?php else: ?>
        <div class="row container-fluid">
            <div class="project-info">
                <center>
                    <h1> <?php bloginfo('name') ?> </h1>
                    <h3> <?php bloginfo('description') ?> </h3>
                </center>
            </div>
            <div id="searchBoxIndex" class="col-md-3 col-sm-12 center">
                <form id="formSearchCollections" role="search">
                    <div class="input-group search-collection search-home">
                        <input style="color:white;" type="text" class="form-control" name="search_collections" id="search_collections" onfocus="changeBoxWidth(this)" placeholder="<?php _e('Find', 'tainacan') ?>"/>
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button"  onclick="redirectAdvancedSearch('#search_collections');"><span class="glyphicon glyphicon-search"></span></button>
                        </span>
                    </div>
                </form>
                <a onclick="redirectAdvancedSearch(false);" href="javascript:void(0)" class="col-md-12 adv_search">
                    <span class="white"><?php _e('Advanced search', 'tainacan') ?></span>
                </a>
             </div>
        </div>

        <?php include_once "views/collection/collec_share.php"; ?>
    <?php endif; ?>
</div>