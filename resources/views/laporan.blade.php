 <table class="table table-striped">
      <thead>
        <tr>
        <th>ID</th>    
        </tr>
      </thead>
      <tbody>
        @foreach ($data as $d)
          <tr>
            <td>{{$d->id}}</td>            
          </tr>
        @endforeach
      </tbody>
</table>