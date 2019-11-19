<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * DeliveryItems Controller
 *
 *
 * @method \App\Model\Entity\DeliveryItem[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DeliveryItemsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $deliveryItems = $this->paginate($this->DeliveryItems);

        $this->set(compact('deliveryItems'));
    }

    /**
     * View method
     *
     * @param string|null $id Delivery Item id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $deliveryItem = $this->DeliveryItems->get($id, [
            'contain' => []
        ]);

        $this->set('deliveryItem', $deliveryItem);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $deliveryItem = $this->DeliveryItems->newEntity();
        if ($this->request->is('post')) {
            $deliveryItem = $this->DeliveryItems->patchEntity($deliveryItem, $this->request->getData());
            if ($this->DeliveryItems->save($deliveryItem)) {
                $this->Flash->success(__('The delivery item has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The delivery item could not be saved. Please, try again.'));
        }
        $this->set(compact('deliveryItem'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Delivery Item id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $deliveryItem = $this->DeliveryItems->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $deliveryItem = $this->DeliveryItems->patchEntity($deliveryItem, $this->request->getData());
            if ($this->DeliveryItems->save($deliveryItem)) {
                $this->Flash->success(__('The delivery item has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The delivery item could not be saved. Please, try again.'));
        }
        $this->set(compact('deliveryItem'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Delivery Item id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $deliveryItem = $this->DeliveryItems->get($id);
        if ($this->DeliveryItems->delete($deliveryItem)) {
            $this->Flash->success(__('The delivery item has been deleted.'));
        } else {
            $this->Flash->error(__('The delivery item could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
