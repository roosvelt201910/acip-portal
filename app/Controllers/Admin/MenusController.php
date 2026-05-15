<?php
class MenusController {
    private $db;
    public function __construct() {
        $this->db = Database::getInstance();
        if (!isAuthenticated()) redirect(url('admin/login'));
    }

    public function index() {
        $menus = $this->db->fetchAll("SELECT * FROM menus ORDER BY id ASC");
        $pageTitle = 'Administrar Menús';
        $currentPage = 'menus';
        require APP_PATH . '/Views/admin/menus/index.php';
    }

    public function manage($id) {
        $menu = $this->db->fetchOne("SELECT * FROM menus WHERE id = :id", ['id' => $id]);
        if (!$menu) redirect(url('admin/menus'));

        // Fetch items ordered by parent (0 first) then order
        // This is a simple fetch, hierarchy visualization logic should be in view or prepared here
        $items = $this->db->fetchAll("
            SELECT m.*, p.titulo as parent_name 
            FROM menu_items m 
            LEFT JOIN menu_items p ON m.parent_id = p.id 
            WHERE m.menu_id = :id 
            ORDER BY m.parent_id ASC, m.orden ASC
        ", ['id' => $id]);

        $pageTitle = 'Gestionar Menú: ' . $menu['nombre'];
        $currentPage = 'menus';
        require APP_PATH . '/Views/admin/menus/manage.php';
    }

    public function createItem($menuId) {
        $menu = $this->db->fetchOne("SELECT * FROM menus WHERE id = :id", ['id' => $menuId]);
        if (!$menu) redirect(url('admin/menus'));

        // Parents for dropdown
        $parents = $this->db->fetchAll("SELECT * FROM menu_items WHERE menu_id = :id AND parent_id IS NULL ORDER BY orden ASC", ['id' => $menuId]);

        $pageTitle = 'Nuevo Elemento de Menú';
        $currentPage = 'menus';
        require APP_PATH . '/Views/admin/menus/create_item.php';
    }

    public function storeItem($menuId) {
        $data = [
            'menu_id' => $menuId,
            'titulo' => $_POST['titulo'],
            'url' => $_POST['url'],
            'parent_id' => !empty($_POST['parent_id']) ? $_POST['parent_id'] : null,
            'orden' => $_POST['orden'] ?? 0,
            'activo' => isset($_POST['activo']) ? 1 : 0
        ];

        $sql = "INSERT INTO menu_items (menu_id, titulo, url, parent_id, orden, activo) 
                VALUES (:menu_id, :titulo, :url, :parent_id, :orden, :activo)";
        
        $this->db->query($sql, $data);
        redirect(url('admin/menus/gestionar/' . $menuId));
    }

    public function editItem($id) {
        $item = $this->db->fetchOne("SELECT * FROM menu_items WHERE id = :id", ['id' => $id]);
        if (!$item) redirect(url('admin/menus'));

        $menuId = $item['menu_id'];
        $parents = $this->db->fetchAll("SELECT * FROM menu_items WHERE menu_id = :id AND parent_id IS NULL AND id != :item_id ORDER BY orden ASC", 
            ['id' => $menuId, 'item_id' => $id]);

        $pageTitle = 'Editar Elemento';
        $currentPage = 'menus';
        require APP_PATH . '/Views/admin/menus/edit_item.php';
    }

    public function updateItem($id) {
        $item = $this->db->fetchOne("SELECT * FROM menu_items WHERE id = :id", ['id' => $id]);
        if (!$item) redirect(url('admin/menus'));

        $data = [
            'id' => $id,
            'titulo' => $_POST['titulo'],
            'url' => $_POST['url'],
            'parent_id' => !empty($_POST['parent_id']) ? $_POST['parent_id'] : null,
            'orden' => $_POST['orden'] ?? 0,
            'activo' => isset($_POST['activo']) ? 1 : 0
        ];

        $sql = "UPDATE menu_items SET 
                titulo = :titulo, 
                url = :url, 
                parent_id = :parent_id, 
                orden = :orden, 
                activo = :activo 
                WHERE id = :id";
        
        $this->db->query($sql, $data);
        redirect(url('admin/menus/gestionar/' . $item['menu_id'] . '?success=1'));
    }

    public function deleteItem($id) {
        $item = $this->db->fetchOne("SELECT * FROM menu_items WHERE id = :id", ['id' => $id]);
        if ($item) {
            $this->db->query("DELETE FROM menu_items WHERE id = :id", ['id' => $id]);
            // Optional: reset parent_id of children or delete them? For now, DB likely restricts or they become orphans.
            // Better to set their parent to NULL usually, but let's keep simple.
            $this->db->query("UPDATE menu_items SET parent_id = NULL WHERE parent_id = :id", ['id' => $id]);
            
            redirect(url('admin/menus/gestionar/' . $item['menu_id']));
        } else {
            redirect(url('admin/menus'));
        }
    }
}
