<?php
/**
 * Elementor oEmbed Widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */
class Elementor_Test_Widget extends \Elementor\Widget_Base {

    
 
    
    
    
    
	/**
	 * Get widget name.
	 *
	 * Retrieve oEmbed widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'oembed';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve oEmbed widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'oEmbed', 'plugin-name' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve oEmbed widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'fa fa-code';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the oEmbed widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'Artem' ];
	}

	/**
	 * Register oEmbed widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function _register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content', 'plugin-name' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'url',
			[
				'label' => __( 'URL to embed', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'url',
				'default' => __( 'https://your-link.com', 'plugin-name' ),
			]
		);

		$this->end_controls_section();

        
        
        
     $this->start_controls_section(
      'style_section',
      [
        'label' => __( 'Style Section', 'elementor' ),
        'tab' => \Elementor\Controls_Manager::TAB_STYLE,
      ]
    );
    $this->add_group_control(
      \Elementor\Group_Control_Typography::get_type(),
      [
        'name' => 'content_typography',
        'label' => __( 'Desde', 'elementor' ),
        'scheme' => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
        'selector' => '.beedirect__best-price .best-price-since',
      ]
    );
    $this->add_group_control(
      \Elementor\Group_Control_Typography::get_type(),
      [
        'name' => 'Value',
        'label' => __( 'Valor', 'elementor' ),
        'scheme' => \Elementor\Scheme_Typography::TYPOGRAPHY_2,
        'selectors' => [
          '.beedirect__best-price .best-price-value' => 'font-family: {{VALUE}}'
        ],
      ]
    );
    $this->add_control(
    'text_color',
      [
        'label' => __( 'Texto', 'elementor' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '#000',
        'selectors' => [
          '.beedirect__best-price .best-price-since' => 'color: {{text_color}}'
        ],
      ]
    );
    $this->add_control(
      'priceColor',
      [
        'name' => 'priceColor',
        'label' => __( 'Preço', 'elementor' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '#f7c410',
        'selectors' => [
          '.beedirect__best-price .best-price-value' => 'color: {{priceColor}}'
        ],
      ]
    );
    $this->add_control(
      'alignment',
      [
        'label' => __( 'Alignment', 'elementor' ),
        'type' => \Elementor\Controls_Manager::CHOOSE,
        'selectors' => [
          '.beedirect__best-price .omnibees-best-price' => 'text-align: {{alignment}}'
        ],
        'options' => [
          'left' => [
            'title' => __( 'Left', 'elementor' ),
            'icon' => 'fa fa-align-left',
          ],
          'center' => [
            'title' => __( 'Center', 'elementor' ),
            'icon' => 'fa fa-align-center',
          ],
          'right' => [
            'title' => __( 'Right', 'elementor' ),
            'icon' => 'fa fa-align-right',
          ],
        ],
        'default' => 'right',
      ]
    );
    $this->end_controls_section();
	}

	/**
	 * Render oEmbed widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();

		$html = wp_oembed_get( $settings['url'] );

		echo '<div class="oembed-elementor-widget">';

		echo ( $html ) ? $html : $settings['url'];

		echo '</div>';

	}

}