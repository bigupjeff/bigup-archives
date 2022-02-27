<?php
/**
 * Bigup: Archives - widget.
 *
 * This template defines the widget including settings form,
 * front end html and saving settings.
 *
 * @package bigup_archives
 * @author Jefferson Real <me@jeffersonreal.com>
 * @copyright Copyright (c) 2021, Jefferson Real
 * @license GPL2+
 */

class Bigup_Archives_Widget extends WP_Widget {


    /**
     * Construct the widget.
     */
    function __construct() {

        $widget_options = array (
            'classname' => 'bigup_archives_widget',
            'description' => 'An archive list menu widget'
        );
        parent::__construct( 'bigup_archives_widget', 'Bigup: Archives', $widget_options );

    }


    /**
     * output widget settings form.
     */
    function form( $instance ) {

        $title = ! empty( $instance['title'] ) ? $instance['title'] : 'Archives';
        $str_post_type = ! empty( $instance['str_post_type'] ) ? $instance['str_post_type'] : 'post';
        $str_archive_type = ! empty( $instance['str_archive_type'] ) ? $instance['str_archive_type'] : 'monthly';
        $int_limit = ! empty( $instance['int_limit'] ) ? $instance['int_limit'] : '8';
        $str_order = ! empty( $instance['str_order'] ) ? $instance['str_order'] : 'DESC';
        $boo_post_count = ! empty( $instance['boo_post_count'] ) ? $instance['boo_post_count'] : 'false';

        ?>

        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
            <input class="widefat"
                   type="text"
                   name="<?php echo $this->get_field_name( 'title' ); ?>"
                   value="<?php echo esc_attr( $title ); ?>"
                   id="<?php echo $this->get_field_id( 'title' ); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'str_post_type' ); ?>">Post Type</label>
            <select class="widefat"
                    name="<?php echo $this->get_field_name( 'str_post_type' ); ?>"
                    id="<?php echo $this->get_field_id( 'str_post_type' ); ?>" >

                <?php //Build a dropdown of post types
                $args = array(
                   'public'   => true,
                );
                $post_types = get_post_types( $args, 'names', 'and' );

                foreach( $post_types as $option ) {
                    //if the option matches the saved setting, mark it up as selected
                    if ( $option == $str_post_type ) {
                        echo '<option value="' . $option . '" ' . 'selected="selected">' . $option . '</option>';
                    } else {
                        echo '<option value="' . $option . '">' . $option . '</option>';
                    }
                }
                ?>

            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'str_archive_type' ); ?>">Post Categorization</label>
            <select class="widefat"
                    name="<?php echo $this->get_field_name( 'str_archive_type' ); ?>"
                    id="<?php echo $this->get_field_id( 'str_archive_type' ); ?>" >

                <?php //Build a dropdown of archive types
                $archive_types = array(
                    "daily"      => "Day",
                    "weekly"     => "Week",
                    "monthly"    => "Month",
                    "yearly"     => "Year",
                    "postbypost" => "Individual Post (date order)",
                    "alpha"      => "Individual Post (alphabetical order)",
                );

                foreach( $archive_types as $key => $option ) {
                    //if the option matches the saved setting, mark it up as selected
                    if ( $key == $str_archive_type ) {
                        echo '<option value="' . $key . '" ' . 'selected="selected">' . $option . '</option>';
                    } else {
                        echo '<option value="' . $key . '">' . $option . '</option>';
                    }
                }
                ?>

            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'int_limit' ); ?>">Maximum Number of Links to List</label>
            <input class="widefat"
                   type="number"
                   step="1"
                   min="1"
                   max="1000"
                   name="<?php echo $this->get_field_name( 'int_limit' ); ?>"
                   value="<?php echo esc_attr( $int_limit ); ?>"
                   id="<?php echo $this->get_field_id( 'int_limit' ); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'str_order' ); ?>">Sort Order</label>
            <select class="widefat"
                   name="<?php echo $this->get_field_name( 'str_order' ); ?>"
                   id="<?php echo $this->get_field_id( 'str_order' ); ?>" />

                <?php
                if ( $str_order == 'ASC' ) {
                    echo '<option value="ASC" selected="selected">Ascending</option>';
                    echo '<option value="DESC">Descending</option>';
                } else {
                    echo '<option value="ASC">Ascending</option>';
                    echo '<option value="DESC" selected="selected">Descending</option>';
                }
                ?>

            </select>
        </p>
        <p>
            <input type="checkbox"
                   name="<?php echo $this->get_field_name( 'boo_post_count' ); ?>"
                   value="true"<?php checked( true, $instance['boo_post_count'] ); ?>
                   id="<?php echo $this->get_field_id( 'boo_post_count' ); ?>">
            <label for="<?php echo $this->get_field_id( 'boo_post_count' ); ?>">Show Post Count in Link Title</label>
        </p>

        <!-- Debug Info
        <?php echo "\n" . 'Title: ' . $title . "\n"; ?>
        <?php echo 'Post Type: ' . $str_post_type . "\n"; ?>
        <?php echo 'Archive Type: ' . $str_archive_type . "\n"; ?>
        <?php echo 'Limit: ' . $int_limit . "\n"; ?>
        <?php echo 'Order: ' . $str_order . "\n"; ?>
        <?php echo 'Count: ' . $boo_post_count . "\n"; ?>
        -->

        <?php
    }


    /**
     * display the widget on the front end.
     */
    function widget( $args, $instance ) {

        // enqueue the styles
        // wp_enqueue_style('bigup_archives_widget_css');

        $title = apply_filters( 'widget_title', $instance['title'] );
        $str_archive_type = $instance['str_archive_type'];
        $int_limit = $instance['int_limit'];
        $boo_post_count = $instance['boo_post_count'];
        $str_order = $instance['str_order'];
        $str_post_type = $instance['str_post_type'];

        echo $args['before_widget'];

        if ( ! empty( $title ) ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }; ?>

            <ul class="widget_ul">

                <?php wp_get_archives(

                    array(
                        "post_type"       => $str_post_type,
                        "type"            => $str_archive_type,
                        "limit"           => $int_limit ,
                        "order"           => $str_order,
                        "show_post_count" => $boo_post_count,
                    )
                ); ?>

            </ul>

        <?php
        echo $args['after_widget'];
    }


    /**
     * define the data saved by the widget.
     */
    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags( $new_instance['title'] );
        $instance['str_archive_type'] = strip_tags( $new_instance['str_archive_type'] );
        $instance['int_limit'] = strip_tags( $new_instance['int_limit'] );
        $instance['boo_post_count'] = isset( $new_instance['boo_post_count'] ) ? true : false;
        $instance['str_order'] = strip_tags( $new_instance['str_order'] );
        $instance['str_post_type'] = strip_tags( $new_instance['str_post_type'] );
        return $instance;
    }

} // Class Bigup_Archives_Widget end

/**
 * Register and load the widget.
 */
function bigup_archives_load_widget() {
    register_widget( 'bigup_archives_widget' );
}
add_action( 'widgets_init', 'bigup_archives_load_widget' );
