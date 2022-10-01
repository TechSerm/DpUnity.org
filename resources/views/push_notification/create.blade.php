<form action="{{route('push_notifications.store')}}" method="post">
    @csrf
    <input type="text" name="title" placeholder="Title"><br/>
    <textarea name="body" id="" cols="30" rows="10"></textarea><br/>
    <input type="text" name="url" placeholder="Url"><br/>
    <input type="text" name="image" placeholder="Image"><br/>
    <input type="submit">
</form>