<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="https://laravel.com/img/notification-logo.png" class="logo" alt="Laravel Logo">
@else
<img src="https://i.postimg.cc/x1Y6k9hz/Cherry-Ticket-Logo.png" class="logo" alt="Cherry Logo">
<h1>{{$slot}}</h1>
@endif
</a>
</td>
</tr>
