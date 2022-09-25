 <table class="table table-striped">
      <thead>       
        <tr>
            @foreach ($data[0]->DATA_PERTANYAAN as $d)         
              <th>ID</th>     
            @endforeach     
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