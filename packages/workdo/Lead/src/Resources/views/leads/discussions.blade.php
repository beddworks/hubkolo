
{{ Form::model($lead, array('route' => array('leads.discussion.store', $lead->id), 'method' => 'POST')) }}
    <div class="modal-body">
        <div class="row">
            <div class="col-12 form-group">
                {{ Form::label('comment', __('Message'),['class'=>'col-form-label']) }}
                {{ Form::textarea('comment', null, array('class' => 'form-control','required'=>'required','rows'=> 5,'placeholder'=> __('Enter Message'))) }}
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn  btn-light" data-bs-dismiss="modal">{{__('Cancel')}}</button>
        <button type="submit" class="btn  btn-primary">{{__('Create')}}</button>
    </div>

{{ Form::close() }}

