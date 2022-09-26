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
             @foreach ($data[0]->DATA_PERTANYAAN as $d)         
              <td>{{$d->DATA_JAWABAN}}</td>       
            @endforeach                        
          </tr>
        @endforeach
      </tbody>
</table>