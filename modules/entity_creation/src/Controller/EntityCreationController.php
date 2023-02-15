<?php

namespace Drupal\entity_creation\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Connection;
use Drupal\node\Entity\Node;
use GuzzleHttp\Client;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Returns responses for Entity creation routes.
 */
class EntityCreationController extends ControllerBase {

  // /**
  //  * The database connection.
  //  *
  //  * @var \Drupal\node\Entity\Node
  //  */
  // // protected $connection;
  // protected $nodeEntity;

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  // protected $entityTypeManager;

  /**
   * The controller constructor.
   *
   * @param \Drupal\node\Entity\Node $nodeEntity
   *   The database connection.
   */
  // public function __construct(EntityTypeManagerInterface $entityTypeManager) {
  //   $this->entityTypeManager = $entityTypeManager;
  // }

  /**
   * {@inheritdoc}
   */
  // public static function create(ContainerInterface $container) {
  //   return new static(
  //     $container->get('entityTypeManager')
  //   );
  // }

  /**
   * Builds the response
   * @param id
   */
  public function build($id) {

    $client = new Client();
    $getRersponse = $client->get('https://anapioficeandfire.com/api/characters/'.$id);
    $responseObj = json_decode($getRersponse->getBody());

    try{
      $node = Node::create([
        'type' => 'character',
        'field_name' => $responseObj->name,
        'field_gender' => $responseObj->gender,
        'field_culture' => $responseObj->culture,
        'field_born' => $responseObj->born,
        'field_died' => $responseObj->died,
        'field_titles' => $responseObj->titles,
        'field_aliases' => $responseObj->aliases,
        'field_father' => $responseObj->father,
        'field_mother' => $responseObj->mother,
        'field_spouse' => $responseObj->spouse,
        'field_allegiances' => $responseObj->allegiances,
        'field_books' => $responseObj->books,
        'field_povbooks' => $responseObj->povBooks,
        'field_tvseries' => $responseObj->tvSeries,
        'field_playedby' => $responseObj->playedBy,
        'title' => 'New Character Obj All',
      ]);
      $node->save();
      $response = "true";
    } catch (Exception $e){
      $response = "false".$e->getMessage();
    }

    return new JsonResponse($response);

  }

}
