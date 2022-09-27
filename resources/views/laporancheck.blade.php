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
                <td style="vertical-align : middle;text-align:center;" rowspan="2"> {{$c->TGL_CHECK}} </td>                
            </tr>
            @endforeach
        </tbody>
       @endforeach     
</table>