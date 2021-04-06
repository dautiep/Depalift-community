@if ($contact)
    <p>{{ trans('plugins/contact::contact.tables.time') }}: <i>{{ $contact->created_at }}</i></p>
    <p>{{ trans('plugins/contact::contact.tables.full_name') }}: <i>{{ $contact->name }}</i></p>
    <p>{{ trans('plugins/contact::contact.tables.email') }}: <i><a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a></i></p>
    <p>{{ trans('plugins/contact::contact.tables.phone') }}: <i>@if ($contact->phone) <a href="tel:{{ $contact->phone }}">{{ $contact->phone }}</a> @else N/A @endif</i></p>
    <p>{{ trans('plugins/contact::contact.tables.address') }}: <i>{{ $contact->address ? $contact->address : 'N/A' }}</i></p>
    <p>{{ trans('plugins/contact::contact.tables.subject') }}: <i>{{ $contact->subject ? $contact->subject : 'N/A' }}</i></p>
    <p>{{__("Doanh nghiệp/Đơn vị")}}: <i>{{ $contact->company ? $contact->company : 'N/A' }}</i></p>
    <p>{{__("Mã số doanh nghiệp")}}: <i>{{ $contact->number_company ? $contact->number_company : 'N/A' }}</i></p>
    <p>{{__("Vấn đề cần trợ giúp")}}: <i>{{ $contact->problem ? $contact->problem : 'N/A' }}</i></p>
    <p>{{__("Tệp tin")}}: <i>{{ $contact->file ? $contact->file : 'N/A' }}</i></p>
    <p>{{ trans('plugins/contact::contact.tables.content') }}:</p>
    <pre class="message-content">{{ $contact->content ? $contact->content : '...' }}</pre>
@endif
