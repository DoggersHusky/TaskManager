<% require javascript("buckleshusky/taskmanager: javascript/jquery-3.3.1.min.js") %>
<% require javascript("buckleshusky/taskmanager: javascript/taskmanager.js") %>
<% require css("buckleshusky/taskmanager: css/taskmanager.css") %>
<div class="tasks-container">
    <div class="new-task-toggle"></div>
    <div class="tasks-toggle"></div>
    <div class="all-tasks-toggle"></div>
    <div class="new-task">
        
        <div class="element-selector">
            <span>Select Element</span>
        </div>
        
        $TaskManagerForm

    </div>
    <div class="all-task">
        <% with $TaskManager %>
            <% if $AllTasks %>
                <% loop $AllTasks.Sort(ID DESC) %>
                    <div class="task">
                        <div class="complete"><a href="{$Top.Link}CompleteTask/$ID"></a></div>
                        <div class="task-info">
                            <div><strong>$Title</strong></div>
                            <div class="date">$Created.Nice</div>
                            <div class="desc">$Description</div>
                            <% if $Element %>
                                <div class="ele"><span data-target="$Element">Show Element</span></div>
                            <% end_if %>
                        </div>
                    </div>
                <% end_loop %>
            <% else %>
                There are no Task for this page.
            <% end_if %>
        <% end_with %>
    </div>
    <div class="tasks">
        <% with $TaskManager %>
            <% if $PageTasks %>
                <% loop $PageTasks.Sort(ID DESC) %>
                    <div class="task">
                        <div class="complete"><a href="{$Top.Link}CompleteTask/$ID"></a></div>
                        <div class="task-info">
                            <div><strong>$Title</strong></div>
                            <div class="date">$Created.Nice</div>
                            <div class="desc">$Description</div>
                            <% if $Element %>
                                <div class="ele"><span data-target="$Element">Show Element</span></div>
                            <% end_if %>
                        </div>
                    </div>
                <% end_loop %>
            <% else %>
                There are no Task for this page.
            <% end_if %>
        <% end_with %>
    </div>
    
</div>