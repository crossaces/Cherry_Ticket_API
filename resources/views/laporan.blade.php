 <table class="table table-striped">
      <thead>       
        <tr>
            @foreach ($data[0]->DATA_PERTANYAAN as $d)         
              <th style="max-width:150px;">{{$d->PERTANYAAN}}</th>     
            @endforeach     
        </tr>
      </thead>
      <tbody>
        @foreach ($data as $d)
          <tr>
             @foreach ($data[0]->DATA_PERTANYAAN as $d)         
              <td style="max-width:150px;">{{$d->DATA_JAWABAN}}</td>       
            @endforeach                        
          </tr>
        @endforeach
      </tbody>
</table>