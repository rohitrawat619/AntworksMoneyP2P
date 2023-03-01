<?php
class Blogmodel extends CI_Model{

    public function __construct(){

        $this->db2 = $this->load->database('blog', TRUE);

    }

    public function get_blogs()
    {
      $blog = '';
        $sql = "SELECT
                        p1.*,
                        CONCAT('https://www.antworksp2p.com/blog/wp-content/uploads/', wm2.meta_value) AS blog_fetured_image
                    FROM
                        ulwkj_posts p1
                    LEFT JOIN
                        ulwkj_postmeta wm1
                        ON (
                            wm1.post_id = p1.id
                            AND wm1.meta_value IS NOT NULL
                            AND wm1.meta_key = '_thumbnail_id'
                        )
                    LEFT JOIN
                        ulwkj_postmeta wm2
                        ON (
                            wm1.meta_value = wm2.post_id
                            AND wm2.meta_key = '_wp_attached_file'
                            AND wm2.meta_value IS NOT NULL
                        )
                    WHERE
                        p1.post_status='publish'
                        AND p1.post_type='post'
                    ORDER BY
                        p1.post_date DESC LIMIT 0,3
                  ";
        $query = $this->db2->query($sql);
        if($this->db2->affected_rows()>0)
        {
            $results = $query->result_array();

            foreach($results AS $result)
            {
                $sql = "SELECT t.`name` AS category 
                        FROM ulwkj_term_relationships tr
                        INNER JOIN ulwkj_term_taxonomy tt ON (tr.term_taxonomy_id = tt.term_taxonomy_id) 
                        INNER JOIN ulwkj_terms t ON (tt.term_id = t.term_id)
                        WHERE tr.object_id = ".$result['ID'];
                $query = $this->db2->query($sql);
                if($this->db2->affected_rows()>0)
                {
                    $categories = array();
                    $category_results = $query->result_array();
                    foreach($category_results AS $category_result)
                    {
                        $categories[] = array('category'=>$category_result['category']);
                    }

                }
                $blog[] = array(
                    'ID'=>$result['ID'],
                    'post_date'=>$result['post_date'],
                    'post_date_gmt'=>$result['post_date_gmt'],
                    'post_content'=>$result['post_content'],
                    'post_title'=>$result['post_title'],
                    'post_status'=>$result['post_status'],
                    'comment_status'=>$result['comment_status'],
                    'ping_status'=>$result['ping_status'],
                    'post_name'=>$result['post_name'],
                    'post_modified'=>$result['post_modified'],
                    'post_modified_gmt'=>$result['post_modified_gmt'],
                    'menu_order'=>$result['menu_order'],
                    'post_type'=>$result['post_type'],
                    'blog_fetured_image'=>$result['blog_fetured_image'],
                    'guid'=>$result['guid'],
                    'categories'=>$categories,
                );
            }



        }
        return $blog;
    }

    public function get_credit_counselling_blogs()
    {

        $sql = "SELECT
                        p1.*,
                        CONCAT('https://www.antworksmoney.com/blog/wp-content/uploads/', wm2.meta_value) AS blog_fetured_image
                    FROM
                        ulwkj_posts p1
                    LEFT JOIN
                        ulwkj_postmeta wm1
                        ON (
                            wm1.post_id = p1.id
                            AND wm1.meta_value IS NOT NULL
                            AND wm1.meta_key = '_thumbnail_id'
                        )
                    LEFT JOIN
                        ulwkj_postmeta wm2
                        ON (
                            wm1.meta_value = wm2.post_id
                            AND wm2.meta_key = '_wp_attached_file'
                            AND wm2.meta_value IS NOT NULL
                        )
                    WHERE
                        p1.post_status='publish'
                        AND p1.post_type='post'
                    ORDER BY
                        p1.post_date DESC LIMIT 0,3
                  ";
        
        $query = $this->db2->query($sql);
        if($this->db2->affected_rows()>0)
        {
            $results = $query->result_array();

            foreach($results AS $result)
            {
                $sql = "SELECT t.`name` AS category 
                        FROM ulwkj_term_relationships tr
                        INNER JOIN ulwkj_term_taxonomy tt ON (tr.term_taxonomy_id = tt.term_taxonomy_id) 
                        INNER JOIN ulwkj_terms t ON (tt.term_id = t.term_id)
                        WHERE tr.object_id = ".$result['ID'];
                $query = $this->db2->query($sql);
                if($this->db2->affected_rows()>0)
                {
                    $categories = array();
                    $category_results = $query->result_array();
                    foreach($category_results AS $category_result)
                    {
                        $categories[] = array('category'=>$category_result['category']);
                    }

                }
                $blog[] = array(
                    'ID'=>$result['ID'],
                    'post_date'=>$result['post_date'],
                    'post_date_gmt'=>$result['post_date_gmt'],
                    'post_content'=>$result['post_content'],
                    'post_title'=>$result['post_title'],
                    'post_status'=>$result['post_status'],
                    'comment_status'=>$result['comment_status'],
                    'ping_status'=>$result['ping_status'],
                    'post_name'=>$result['post_name'],
                    'post_modified'=>$result['post_modified'],
                    'post_modified_gmt'=>$result['post_modified_gmt'],
                    'menu_order'=>$result['menu_order'],
                    'post_type'=>$result['post_type'],
                    'blog_fetured_image'=>$result['blog_fetured_image'],
                    'guid'=>$result['guid'],
                    'categories'=>$categories,
                );
            }



        }
        return $blog;
    }


}
?>