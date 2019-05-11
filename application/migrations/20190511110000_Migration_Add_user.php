<?php

/*
  | Column           | Data type     | Note
  | ---------------- | ------------- | -------------------------------------
  | id               | INTEGER       | AUTO_INCREMENT, UNSIGNED                                                          |
  | uuid             | CHAR(36)      | or CHAR(16) binary                                                                |
  | title            | VARCHAR(255)  |                                                                                   |
  | full name        | VARCHAR(70)   |                                                                                   |
  | gender           | TINYINT       | UNSIGNED                                                                          |
  | description      | TINYTEXT      | often may not be enough, use TEXT
  instead
  | post body        | TEXT          |                                                                                   |
  | email            | VARCHAR(255)  |                                                                                   |
  | url              | VARCHAR(2083) | MySQL version < 5.0.3 - use TEXT                                                  |
  | salt             | CHAR(x)       | randomly generated string, usually of
  fixed length (x)
  | digest (md5)     | CHAR(32)      |                                                                                   |
  | phone number     | VARCHAR(20)   |                                                                                   |
  | US zip code      | CHAR(5)       | Use CHAR(10) if you store extended
  codes
  | US/Canada p.code | CHAR(6)       |                                                                                   |
  | file path        | VARCHAR(255)  |                                                                                   |
  | 5-star rating    | DECIMAL(3,2)  | UNSIGNED                                                                          |
  | price            | DECIMAL(10,2) | UNSIGNED                                                                          |
  | date (creation)  | DATE/DATETIME | usually displayed as initial date of
  a post                                       |
  | date (tracking)  | TIMESTAMP     | can be used for tracking changes in a
  post                                        |
  | tags, categories | TINYTEXT      | comma separated values *                                                          |
  | status           | TINYINT(1)    | 1 – published, 0 – unpublished, … You
  can also use ENUM for human-readable
  values
  | json data        | JSON          | or LONGTEXT
 */

/**
 * Description of Migration_Add_user
 *
 * @author fulvi
 */
class Migration_Add_user extends CI_Migration {

    public function __construct($config = array()): void {
        parent::__construct($config);
        $this->lang->load('table/role',$config['language']);
        $this->lang->load('table/behavior',$config['language']);
    }

        public function up() {
        //table role
        $attributes = array('ENGINE' => 'InnoDB');
        $this->dbforge->add_field('id');
        $fields = [
            'name' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
//                'null' => TRUE,
//                'default' => 'King of Town',
//                'unique' => TRUE,
//                'unsigned' => TRUE,
//                'auto_increment' => TRUE
            ),
        ];
        $this->dbforge->add_field($fields);
        $this->dbforge->create_table('role', TRUE, $attributes);
        
                
        $this->db->insert('role', ['name' => $this->lang->line('Administrator')]);
        $administratos_insert_id = $this->db->insert_id();

        $this->dbforge->add_field('id');
        $this->dbforge->add_field([
            'name' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
//                'null' => TRUE,
//                'default' => 'King of Town',
//                'unique' => TRUE,
//                'unsigned' => TRUE,
//                'auto_increment' => TRUE
            ),
        ]);
        $this->dbforge->create_table('behavior', TRUE, $attributes);
        $this->db->insert('behavior', ['name' => $this->lang->line('Hide')]);
        $this->db->insert('behavior', ['name' => $this->lang->line('Read Only')]);

        //table user
        $this->dbforge->add_field('id');
        $this->dbforge->add_field([
            'first_name' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => TRUE,
//                'default' => 'King of Town',
//                'unique' => TRUE,
//                'unsigned' => TRUE,
//                'auto_increment' => TRUE
            ),
            'last_name' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => TRUE,
//                'default' => 'King of Town',
//                'unique' => TRUE,
//                'unsigned' => TRUE,
//                'auto_increment' => TRUE
            ),
            'email' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
//                'null' => TRUE,
//                'default' => 'King of Town',
//                'unique' => TRUE,
//                'unsigned' => TRUE,
//                'auto_increment' => TRUE
            ),
            'passwd' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
//                'null' => TRUE,
//                'default' => 'King of Town',
//                'unique' => TRUE,
//                'unsigned' => TRUE,
//                'auto_increment' => TRUE
            ),
            'id_role' => array(
                'type' => 'INT',
//                'constraint' => '9',
                'null' => TRUE,
//                'default' => 'King of Town',
//                'unique' => TRUE,
//                'unsigned' => TRUE,
//                'auto_increment' => TRUE
            ),
        ]);
        $this->dbforge->create_table('user', TRUE, $attributes);
        $this->db->insert('user', [
            'first_name' => 'Fulvius',
            'last_name' => 'Titanero Guelfi',
            'email' => 'fulvius@gpmail.com.br',
            'paswd' => 'h7t846m2',
            'id_role' => $administratos_insert_id
        ]);

        $this->dbforge->add_field('id');
        $this->dbforge->add_field([
            'id_role' => array(
                'type' => 'INT',
//                'constraint' => '9',
//                'null' => TRUE,
//                'default' => 'King of Town',
//                'unique' => TRUE,
//                'unsigned' => TRUE,
//                'auto_increment' => TRUE
            ),
            'slug' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
//                'null' => TRUE,
//                'default' => 'King of Town',
//                'unique' => TRUE,
//                'unsigned' => TRUE,
//                'auto_increment' => TRUE
            ),
        ]);
        $this->dbforge->create_table('permission', TRUE, $attributes);
        $this->db->insert('permission', ['id_role' => $administratos_insert_id, 'slug' => 'migrate']);
        $this->db->insert('permission', ['id_role' => $administratos_insert_id, 'slug' => 'migrate/index']);

        $this->dbforge->add_field('id CHAR(36) PRIMARY KEY DEFAULT uuid()');
        $this->dbforge->add_field([
            'id_permission' => array(
                'type' => 'INT',
//                'constraint' => '9',
//                'null' => TRUE,
//                'default' => 'King of Town',
//                'unique' => TRUE,
//                'unsigned' => TRUE,
//                'auto_increment' => TRUE
            ),
            'description' => array(
                'type' => 'TEXT',
//                'constraint' => '255',
//                'null' => TRUE,
//                'default' => 'King of Town',
//                'unique' => TRUE,
//                'unsigned' => TRUE,
//                'auto_increment' => TRUE
            ),
        ]);
        $this->dbforge->create_table('element', TRUE, $attributes);

        $this->dbforge->add_field('id');
        $this->dbforge->add_field([
            'id_element' => array(
                'type' => 'CHAR',
                'constraint' => '36',
//                'null' => TRUE,
//                'default' => 'King of Town',
//                'unique' => TRUE,
//                'unsigned' => TRUE,
//                'auto_increment' => TRUE
            ),
            'id_user' => array(
                'type' => 'INT',
//                'constraint' => '9',
//                'null' => TRUE,
//                'default' => 'King of Town',
//                'unique' => TRUE,
//                'unsigned' => TRUE,
//                'auto_increment' => TRUE
            ),
            'id_behavior' => array(
                'type' => 'INT',
//                'constraint' => '9',
//                'null' => TRUE,
//                'default' => 'King of Town',
//                'unique' => TRUE,
//                'unsigned' => TRUE,
//                'auto_increment' => TRUE
            ),
        ]);
        $this->dbforge->create_table('user_element_behavior', TRUE, $attributes);
    }

    public function down() {
        $this->dbforge->drop_table('user_element_behavior');
        $this->dbforge->drop_table('element');
        $this->dbforge->drop_table('permission');
        $this->dbforge->drop_table('user');
        $this->dbforge->drop_table('behavior');
        $this->dbforge->drop_table('role');
    }

}