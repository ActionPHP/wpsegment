<script type="text/template" id="quiz-template">

<ol id="question-list" ></ol>

<p>
<input type="button" value="+ Add question" id="add-question-button" />
</p>

</script>

<script type="text/template" id="question-template">
	<span class="question-text" style="font-weight: bold;"><%= text != null ? text : 'Click here to edit'  %></span> <span class="remove-question" >x Remove question</span>
	<span class="question-messages" style="margin-left: 25px;" ></span>
	<ul class="answer-space" style="list-style-type: lower-latin; margin: 15px"></ul>
	<a class="add-answer" >+ Add answer</a>
</script>

<script type="text/template" id="answer-template">
	<span class="answer-text" ><%= text != null ? text : 'Click here add answer.' %></span>

	<span style="margin-left: 50px" ><a href="" class="custom-response" >Custom response</a></span>

	<span style="margin-left: 50px" ><em>Points: </em></span>

	<span class="points-text" ><%= points %></span>
	
	<span class="remove-answer" > <a  > x Remove </a> </span>

	<span class="answer-messages" style="margin-left: 25px;" ></span>

	<div class="modal-area"></div>
</script>

<script type="text/template" id="modal-template">
<div class="modal hide fade">
	  <div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	    <h3 id="modal-header"></h3>
	  </div>
	  <div class="modal-body">
	    <textarea id="modal-textarea" style="padding: 10px; width: 500px; height: 200px; border: none;"></textarea>
	  </div>
	  <div class="modal-footer">
	    <a href="#" class="btn" data-dismiss="modal">Close</a>
	    <a href="#" class="btn btn-primary save-custom-response">Save changes</a>
	  </div>
	</div>
</script>