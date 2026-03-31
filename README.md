# Application web Côte Info

Mode objet MVC model


abstract class Model {
    protected $tableName;

    public getById($id){
        SELECT * FROM this->tablename WHERE `this->tablename`.id = $id
    }
}

class UserModel extends Model{

    //on peut créer une association avec une autre classe ("User") telle que :
    //private User $user;

    public function __construct()
    {
        $this->tableName = "USER";
    }
}

