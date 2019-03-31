<?php
/* Smarty version 3.1.31, created on 2019-04-01 00:08:16
  from "/home/rohit/Projects/user-management/src/Naukri/JobPostingGatewayBundle/Resources/views/layout.html.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5ca10918f12758_05263455',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '7a8aeeb56b787425735d93d01fed2236589f56cd' => 
    array (
      0 => '/home/rohit/Projects/user-management/src/Naukri/JobPostingGatewayBundle/Resources/views/layout.html.tpl',
      1 => 1554028628,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5ca10918f12758_05263455 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, false);
?>
<!DOCTYPE html> <html lang="en"> <head> <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700"></link> <meta charset="UTF-8"> <meta name="viewport" content="width=device-width, initial-scale=1"> <title> <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_20418245875ca10918f0f735_36663487', 'title');
?>
 </title> <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_18317779575ca10918f103a7_02034340', 'headlinks');
?>
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css"> <?php echo '<script'; ?>
 src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"><?php echo '</script'; ?>
> <?php echo '<script'; ?>
 src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"><?php echo '</script'; ?>
> </head> <body> <noscript> <div style="font:normal 11px Verdana; color:#000; padding:2px;border-bottom:1px solid #e1deac; background:#fffbc0;"><img src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['JPIMAGESURL']->value, ENT_QUOTES, 'UTF-8');?>
/warning.gif" width="32" height="32" hspace="5" align="absmiddle"> Javascript is disabled in your browser due to this certain functionalities will not work. <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['ENABLE_JS_PATH']->value, ENT_QUOTES, 'UTF-8');?>
"target="_blank">Click Here</a>, to know how to enable it.</div> </noscript> <div class="bodyWrap"> <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_3718149935ca10918f11533_25958106', 'body');
?>
 </div> <div class="footerHtml"></div> <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_12867396685ca10918f11e90_68236509', 'js_init');
?>
 </body> </html><?php }
/* {block 'title'} */
class Block_20418245875ca10918f0f735_36663487 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'title' => 
  array (
    0 => 'Block_20418245875ca10918f0f735_36663487',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>
Admin Console<?php
}
}
/* {/block 'title'} */
/* {block 'headlinks'} */
class Block_18317779575ca10918f103a7_02034340 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'headlinks' => 
  array (
    0 => 'Block_18317779575ca10918f103a7_02034340',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block 'headlinks'} */
/* {block 'body'} */
class Block_3718149935ca10918f11533_25958106 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'body' => 
  array (
    0 => 'Block_3718149935ca10918f11533_25958106',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block 'body'} */
/* {block 'js_init'} */
class Block_12867396685ca10918f11e90_68236509 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'js_init' => 
  array (
    0 => 'Block_12867396685ca10918f11e90_68236509',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>
 <?php
}
}
/* {/block 'js_init'} */
}
