<% if $IncludeJuery %>
    <% require javascript("buckleshusky/taskmanager: javascript/jquery-3.3.1.min.js") %>
<% end_if %>
<% require javascript("buckleshusky/taskmanager: javascript/jquery.dom-outline-1.0.js") %>
<% require javascript("buckleshusky/taskmanager: javascript/taskmanager.js") %>
<% require css("buckleshusky/taskmanager: css/taskmanager.css") %>
<div class="tasks-container">
    <div class="task-button-holder">
        <div class="new-task-toggle toggle" data-target="new-task">New Task</div>
        <div class="tasks-toggle toggle" data-target="tasks">Page's Tasks</div>
        <div class="all-tasks-toggle toggle" data-target="all-tasks">All Tasks</div>
    </div>
    <div class="task-holder">
        <div class="new-task">
            <div class="element-selector">
                <span>Select Element</span>
            </div>
            
            $TaskManagerForm
        </div>
        <div class="all-tasks">
            <% with $TaskManager %>
                $CompletedTasks/$TotalTasks
                <% if $AllTasks %>
                    <% loop $AllTasks.Sort(ID DESC) %>
                        <div class="task">
                            <div class="complete">
                                <% if $GitHubIssue %>
                                    <a href="$GitHubLink" target="_blank"><img src="$resourceURL(buckleshusky/taskmanager: images/github.png)" width="30" height="30" /></a>
                                <% else %>
                                    <a href="{$Top.Link}CompleteTask/$ID" class="complete-issue"></a>
                                <% end_if %>
                            </div>
                            <div class="task-info">
                                <div><strong>$Title</strong></div>
                                <div class="date">
                                    <strong>$Member.FirstName</strong> - $Created.Nice
                                </div>
                                <div class="desc">
                                    $Description
                                </div>
                                <% if $Top.ID == $Page.ID %>
                                    <% if $Element %>
                                        <div class="ele">
                                            <span data-target='$Element'>Show Element</span>
                                        </div>
                                    <% end_if %>
                                <% else %>
                                <div class="ele">
                                    <a href="$Page.Link">Go to Page</a>
                                </div>
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
                $PageCompletedTasks/$PageTotalTasks
                <% if $PageTasks %>
                    <% loop $PageTasks.Sort(ID DESC) %>
                        <div class="task">
                            <div class="complete">
                                <% if $GitHubIssue %>
                                    <a href="$GitHubLink" target="_blank"><img src="$resourceURL(buckleshusky/taskmanager: images/github.png)" width="30" height="30" /></a>
                                <% else %>
                                    <a href="{$Top.Link}CompleteTask/$ID" class="complete-issue"></a>
                                <% end_if %>
                            </div>
                            <div class="task-info">
                                <div>
                                    <strong>$Title</strong>
                                </div>
                                <div class="date">
                                    <strong>$Member.FirstName</strong> - $Created.Nice
                                </div>
                                <div class="desc">$Description</div>
                                <% if $Element %>
                                    <div class="ele">
                                        <span data-target='$Element'>Show Element</span>
                                    </div>
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
</div>
