<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Transportsize Entity
 *
 * @property int $id
 * @property string $size_type
 * @property float $height
 * @property float $width
 * @property float $weight
 *
 * @property \App\Model\Entity\Transport[] $transport
 */
class Transportsize extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'size_type' => true,
        'height' => true,
        'width' => true,
        'weight' => true,
        'transport' => true
    ];
}
