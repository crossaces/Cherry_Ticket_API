 <table class="table table-striped">
      <thead>       
        <tr>
            @foreach ($data[0]->DATA_PERTANYAAN as $d)         
              <th>{{$d->PERTANYAAN}}</th>     
            @endforeach     
        </tr>
      </thead>
      <tbody>
        @foreach ($data as $d)
          <tr>
             @foreach ($d->DATA_JAWABAN as $s)         
              <td>{{$s->DATA_JAWABAN}}</td>       
            @endforeach                        
          </tr>
        @endforeach
      </tbody>
</table>