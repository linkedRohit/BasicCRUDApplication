<?php
/* Smarty version 3.1.31, created on 2019-04-01 00:08:16
  from "/home/rohit/Projects/user-management/src/Naukri/JobPostingGatewayBundle/Resources/views/Default/index.html.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5ca10918f08f86_52552232',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a4fec3fb4ebc19e781fa0f1597740116615640c0' => 
    array (
      0 => '/home/rohit/Projects/user-management/src/Naukri/JobPostingGatewayBundle/Resources/views/Default/index.html.tpl',
      1 => 1554056978,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5ca10918f08f86_52552232 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>
 <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_16703976795ca10918ef5d67_61462509', 'headlinks');
?>
 <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_14725019155ca10918ef6b48_77499197', 'css_init_module');
?>
 <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_712134965ca10918ef74c5_44667284', 'body');
?>
 <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1361247615ca10918f08410_09378402', 'js_init_modile');
?>
 <?php $_smarty_tpl->inheritance->endChild($_smarty_tpl, 'file:NaukriJobPostingGatewayBundle::layout.html.tpl');
}
/* {block 'headlinks'} */
class Block_16703976795ca10918ef5d67_61462509 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'headlinks' => 
  array (
    0 => 'Block_16703976795ca10918ef5d67_61462509',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>
 <?php
}
}
/* {/block 'headlinks'} */
/* {block 'css_init_module'} */
class Block_14725019155ca10918ef6b48_77499197 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'css_init_module' => 
  array (
    0 => 'Block_14725019155ca10918ef6b48_77499197',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>
 <?php
}
}
/* {/block 'css_init_module'} */
/* {block 'body'} */
class Block_712134965ca10918ef74c5_44667284 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'body' => 
  array (
    0 => 'Block_712134965ca10918ef74c5_44667284',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>
 <?php echo '<script'; ?>
 type="text/javascript">
            function deleteGroup(id) {
		$.ajax({
		    url: '/accounts/group/' + id,
		    method: 'DELETE',
		    success: function(result) {
		        alert("success");
		    },
		    error: function(request,msg,error) {
		        alert(request.responseText);
		    }
		});
		location.reload();
            }

            function deleteUser(id) {
                $.ajax({
                    url: '/accounts/user/' + id,
                    method: 'DELETE',
                    success: function(result) {
                        alert("success");
                    },
                    error: function(request,msg,error) {
                        alert(request.responseText);
                    }
                });
                location.reload();
            }
 
            function removeFromGroup(id, groupId) {
                $.post("/accounts/user/remove",
                {
                    userId: id,
                    groupId: groupId
                },
                function(data, status) {
                    alert(status);
                });
                location.reload();
            }

            function assignGroup(id) {
		alert("asd");
	    }
    <?php echo '</script'; ?>
> <div id="root" class="container-fluid"> <h1>Manage your users</h1> <blockquote>Groups</blockquote> <div class="row"> <div class="col-md-6"> <h3>Create new group</h3> <form name="group" id="groupForm"> <input type="text" name="name" placeholder="Enter group name" required id="group"> <button class="btn btn-sm btn-primary" id="createGroup" type="submit">Create</button> </form> </div> <div class="col-md-6"> <h3>Your groups</h3> <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['groups']->value, 'group', false, 'id');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['id']->value => $_smarty_tpl->tpl_vars['group']->value) {
?> <li><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['group']->value['name'], ENT_QUOTES, 'UTF-8');?>
 <?php if ($_smarty_tpl->tpl_vars['group']->value['active'] == 'N') {?>(Inactive)<?php }?><a href="javascript:void(0)" class="label label-sm label-danger" onclick="deleteGroup(<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['group']->value['id'], ENT_QUOTES, 'UTF-8');?>
)">Delete</a></li> <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>
 </div> </div> <br/><br/><br/><hr/><br/><br/> <blockquote>Users</blockquote> <div class="row"> <div class="col-md-6"> <h3>Create new user</h3> <form name="user" id="userForm"> <input type="text" name="name" placeholder="Enter user name" id="user" required> <button type="submit" class="btn btn-sm btn-primary" id="createUser">Create</button> </form> </div> <div class="col-md-6"> <h3>Your users</h3> <button class="btn btn-md btn-success" data-toggle="modal" data-target="#assignGroupModal">Assign Group</button> <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['users']->value, 'user', false, 'id');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['id']->value => $_smarty_tpl->tpl_vars['user']->value) {
?> <li><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['user']->value['name'], ENT_QUOTES, 'UTF-8');?>
 <?php if ($_smarty_tpl->tpl_vars['user']->value['active'] == 'N') {?>(Inactive)<?php }?> <a href="javascript:void(0)" class="label label-md label-danger" onclick="deleteUser(<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['user']->value['id'], ENT_QUOTES, 'UTF-8');?>
)">Delete</a> <?php $_smarty_tpl->_assignInScope('cnt', "0");
?> <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['map']->value, 'mapping', false, 'userId');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['userId']->value => $_smarty_tpl->tpl_vars['mapping']->value) {
?> <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['mapping']->value, 'mappin', false, 'id');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['id']->value => $_smarty_tpl->tpl_vars['mappin']->value) {
?> <?php if ($_smarty_tpl->tpl_vars['userId']->value == $_smarty_tpl->tpl_vars['user']->value['id']) {?><a href="javascript:void(0)" class="label label-xs label-default" onclick="removeFromGroup(<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['user']->value['id'], ENT_QUOTES, 'UTF-8');?>
, <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['mappin']->value['id'], ENT_QUOTES, 'UTF-8');?>
)"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['mappin']->value['name'], ENT_QUOTES, 'UTF-8');?>
 &times;</a><?php }?> <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>
 <?php $_smarty_tpl->_assignInScope('cnt', $_smarty_tpl->tpl_vars['cnt']->value+1);
?> <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>
 </li> <br/> <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>
 </div> </div> <div id="assignGroupModal" class="modal fade" role="dialog"> <div class="modal-dialog"> <div class="modal-content"> <form name="assignGroup" id="assignGroupForm"> <div class="modal-header"> <button type="button" class="close" data-dismiss="modal">&times;</button> <h4 class="modal-title">Assign group</h4> </div> <div class="modal-body"> <div class="form-group"> <label for="userItem">Select user:</label> <select class="form-control" id="userItem" name="userId" required> <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['users']->value, 'user', false, 'id');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['id']->value => $_smarty_tpl->tpl_vars['user']->value) {
?> <option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['user']->value['id'], ENT_QUOTES, 'UTF-8');?>
" <?php if ($_smarty_tpl->tpl_vars['user']->value['active'] == 'N') {?>disabled<?php }?>><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['user']->value['name'], ENT_QUOTES, 'UTF-8');
if ($_smarty_tpl->tpl_vars['user']->value['active'] == 'N') {?>(Inactive)<?php }?></option> <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>
 </select> </div> <div class="form-group"> <label for="groupItem">Select groups (Press Ctrl to select multiple values):</label> <select multiple class="form-control" id="groupItem" required name="groupList"> <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['groups']->value, 'group', false, 'id');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['id']->value => $_smarty_tpl->tpl_vars['group']->value) {
?> <option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['group']->value['id'], ENT_QUOTES, 'UTF-8');?>
" <?php if ($_smarty_tpl->tpl_vars['group']->value['active'] == 'N') {?>disabled<?php }?>><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['group']->value['name'], ENT_QUOTES, 'UTF-8');
if ($_smarty_tpl->tpl_vars['group']->value['active'] == 'N') {?>(Inactive)<?php }?></option> <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>
 </select> </div> <button type="submit" class="btn btn-md btn-primary" id="assignGroup">Assign</button> </div> </form> <div class="modal-footer"> <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> </div> </div> </div> </div> </div> <?php echo '<script'; ?>
 type="text/javascript">
        $(document).ready(function() {
            $("#userForm").submit(function(e){
                e.preventDefault();
		var name = $("#user").val();
		$.post("/accounts/user",
		{
		    name: name
		},
		function(data, status) {
		    alert(status);
	        });
		location.reload();
            });

            $("#groupForm").submit(function(e){
                e.preventDefault();
                var name = $("#group").val();
                $.post("/accounts/group",
                {
                    name: name
                },
                function(data, status) {
                    alert(status);
                });
                location.reload();
            });

            $("#assignGroupForm").submit(function(e){
                e.preventDefault();
                var name = $("#userItem").val();
		var groups = $('#groupItem').val();
                $.post("/accounts/user/assign",
                {
                    userId: name,
                    groupId: groups
                },
                function(data, status) {
                    alert(status);
                });
                location.reload();
            });
        });
    <?php echo '</script'; ?>
> <?php
}
}
/* {/block 'body'} */
/* {block 'js_init_modile'} */
class Block_1361247615ca10918f08410_09378402 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'js_init_modile' => 
  array (
    0 => 'Block_1361247615ca10918f08410_09378402',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>
 <?php
}
}
/* {/block 'js_init_modile'} */
}
