 <table class="table table-striped">
      <thead>
         @foreach ($data[0]->DATA_PERTANYAAN as $d)
          <tr>
            <td>{{$d->PERTANYAAN}}</td>            
          </tr>
        @endforeach
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