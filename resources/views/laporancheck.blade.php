 <table class="table table-striped">
     @foreach ($data as $d)     
      <thead>       
        <tr>               
            <th colspan="3" style="text-align: center;">{{$d->peserta->NAMA_DEPAN}} {{$d->peserta->NAMA_BELAKANG}}</th>     
        </tr>
      </thead>
      <tbody>
        @foreach ($d->check as $c)
          <tr>
             {{$c->TGL_CHECK}}          
          </tr>
        @endforeach
      </tbody>
       @endforeach     
</table>