<table class="table">
    <thead>
        <th>Nom</th>
    </thead>
    <tbody>
        @foreach($tags as $tag)
            <tr>
                <td> {{ $tag->name }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

