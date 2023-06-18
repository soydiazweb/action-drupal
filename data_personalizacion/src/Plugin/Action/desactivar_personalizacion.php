<?php

namespace Drupal\data_personalizacion\Plugin\Action;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Action\ActionBase;
use Drupal\Core\Messenger\MessengerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Session\AccountInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * A basic example action that does nothing.
 *
 * @Action(
 *   id = "desactivar_personalizacion_action",
 *   label = @Translation("Action Example: A basic example action that does nothing"),
 *   type = "media"
 * )
 */
class desactivar_personalizacion extends ActionBase implements ContainerFactoryPluginInterface {

  /**
   * Construct a activar_personalizacion entity.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin ID for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Messenger\MessengerInterface $messenger
   *   The messenger service.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, MessengerInterface $messenger) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->setMessenger($messenger);
  }

  /**
   * {@inheritDoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('messenger')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function execute($entity = NULL) {

    if( $entity->hasField('field_lv_customize_cinemagraph') ){
      $entity->field_lv_customize_cinemagraph->value = 0;
      $entity->save();

      $this->messenger()->addMessage($this->t('Se ha desactivado la personalización correctamente'));
    }

  }

  /**
   * {@inheritDoc}
   */
  public function access($entity, AccountInterface $account = NULL, $return_as_object = FALSE) {
    $result = AccessResult::allowed();
    return $return_as_object ? $result : $result->isAllowed();
  }

}
