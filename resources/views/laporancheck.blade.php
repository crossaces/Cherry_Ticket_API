 <table class="table table-striped">
      <thead>       
        <tr>
            @foreach ($data as $d)         
              <th rowspan="2">{{$d->NAMA_DEPAN}} {{$d->NAMA_BELAKANG}}</th>     
            @endforeach     
        </tr>
      </thead>
      <tbody>
        @foreach ($d->check as $c)
          <tr>
             {{$c->TGL_CHECK}}          
          </tr>
        @endforeach
      </tbody>
</table>