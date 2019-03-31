~extends 'file:NaukriJobPostingGatewayBundle::layout.html.tpl'`

~block name=headlinks`
~/block`

~block name=css_init_module`
~/block`

~block name=body`
    <script type="text/javascript">
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
    </script>

    <div id="root" class="container-fluid">
	<h1>Manage your users</h1>
        <blockquote>Groups</blockquote>
	<div class="row">
            <div class="col-md-6">
	        <h3>Create new group</h3>
		<form name="group" id="groupForm">
		    <input type="text" name="name" placeholder="Enter group name" required id="group">
		    <button class="btn btn-sm btn-primary" id="createGroup" type="submit">Create</button>
		</form>
            </div>
            <div class="col-md-6">
                <h3>Your groups</h3>
		~foreach from=$groups key=id item=group`
                    <li>~$group.name` ~if $group.active eq 'N'`(Inactive)~/if`<a href="javascript:void(0)" class="label label-sm label-danger" onclick="deleteGroup(~$group.id`)">Delete</a></li>
                ~/foreach`
            </div>
	</div>
        <br/><br/><br/><hr/><br/><br/>
        <blockquote>Users</blockquote>
        <div class="row">
            <div class="col-md-6">
                <h3>Create new user</h3>
                <form name="user" id="userForm">
                    <input type="text" name="name" placeholder="Enter user name" id="user" required>
                    <button type="submit" class="btn btn-sm btn-primary" id="createUser">Create</button>
		</form>
            </div>
            <div class="col-md-6">
                <h3>Your users</h3>
		<button class="btn btn-md btn-success" data-toggle="modal" data-target="#assignGroupModal">Assign Group</button>
		~foreach from=$users key=id item=user`
	            <li>~$user.name` ~if $user.active eq 'N'`(Inactive)~/if`
                        <a href="javascript:void(0)" class="label label-md label-danger" onclick="deleteUser(~$user.id`)">Delete</a>
<!--                        <a href="javascript:void(0)" class="label label-md label-primary" data-toggle="modal" data-target="#assignGroupModal" onclick="assignGroup(~$user.id`)">Assign Group</a>-->
			~assign var=cnt value="0"`
			~foreach from=$map key=userId item=mapping`
			    ~foreach from=$mapping key=id item=mappin`
                	        ~if $userId eq $user.id`<a href="javascript:void(0)" class="label label-xs label-default" onclick="removeFromGroup(~$user.id`, ~$mappin.id`)">~$mappin.name` &times;</a>~/if`
			    ~/foreach`
			    ~assign var=cnt value=$cnt+1`
			~/foreach`
                    </li>
			<br/>
	        ~/foreach`
            </div>
        </div>
	<div id="assignGroupModal" class="modal fade" role="dialog">
	  <div class="modal-dialog">
	    <!-- Modal content-->
	    <div class="modal-content">
		<form name="assignGroup" id="assignGroupForm">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	        <h4 class="modal-title">Assign group</h4>
	      </div>
	      <div class="modal-body">
		      <div class="form-group">
			  <label for="userItem">Select user:</label>
			  <select class="form-control" id="userItem" name="userId" required>
			    ~foreach from=$users key=id item=user`
                                <option value="~$user.id`" ~if $user.active eq 'N'`disabled~/if`>~$user.name`~if $user.active eq 'N'`(Inactive)~/if`</option>
                            ~/foreach`
			  </select>
		      </div>
                      <div class="form-group">
                          <label for="groupItem">Select groups (Press Ctrl to select multiple values):</label>
                          <select multiple class="form-control" id="groupItem" required name="groupList">
                            ~foreach from=$groups key=id item=group`
                                <option value="~$group.id`" ~if $group.active eq 'N'`disabled~/if`>~$group.name`~if $group.active eq 'N'`(Inactive)~/if`</option>
                            ~/foreach`
                          </select>
                      </div>
                      <button type="submit" class="btn btn-md btn-primary" id="assignGroup">Assign</button>
	      </div>
                  </form>
	      <div class="modal-footer">
        	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	      </div>
	    </div>
	  </div>
	</div>
    </div>
    <script type="text/javascript">
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
    </script>
~/block`
~block name=js_init_modile`
~/block`
