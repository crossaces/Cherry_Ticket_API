 <table class="table table-striped">
      <thead>       
        <tr>
            @foreach ($data as $d)         
              <th rowspan="2">{{$d->NAMA_DEPAN $d->NAMA_BELAKANG}}</th>     
            @endforeach     
        </tr>
      </thead>
      <tbody>
        @foreach ($data as $d)
          <tr>
             @foreach ($data[0]->DATA_JAWABAN as $d)         
              <td>{{$d->DATA_JAWABAN}}</td>       
            @endforeach                        
          </tr>
        @endforeach
      </tbody>
</table>