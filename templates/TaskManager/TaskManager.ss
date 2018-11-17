<% require javascript("buckleshusky/taskmanager: javascript/taskmanager.js") %>
<% require css("buckleshusky/taskmanager: css/taskmanager.css") %>
<div class="tasks-container">
    <div class="tasks-toggle"></div>
    <div class="new-task-toggle"></div>
    <div class="new-task">
    </div>
    <div class="tasks">
        <% with $TaskManager %>
            <% loop $PageTasks %>
                <div class="task">
                    <div>$Title</div>
                    <div>$Description</div>
                    <div>$Complete.Nice</div>
                </div>
            <% end_loop %>
        <% end_with %>
    </div>
    
</div>