<% require javascript("buckleshusky/taskmanager: javascript/taskmanager.js") %>
<% require css("buckleshusky/taskmanager: css/taskmanager.css") %>
<div class="tasks-container">
    <div class="new-task-toggle"></div>
    <div class="tasks-toggle"></div>
    <div class="new-task">
        
        <div class="element-selector">
            <span>Select Element</span>
        </div>
        
        $TaskManagerForm

    </div>
    <div class="tasks">
        <% with $TaskManager %>
            <% loop $PageTasks.Sort(ID DESC) %>
                <div class="task">
                    <div class="complete">$Complete.Nice</div>
                    <div class="task-info">
                        <div><strong>$Title</strong></div>
                        <div class="date">$Created.Nice</div>
                        <div class="desc">$Description</div>
                        <div class="ele"><span data-target="$Element">Show Element</span></div>
                    </div>
                </div>
            <% end_loop %>
        <% end_with %>
    </div>
    
</div>