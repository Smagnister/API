<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Refund Controller
 *
 *
 * @method \App\Model\Entity\Refund[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RefundController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $refund = $this->paginate($this->Refund);

        $this->set(compact('refund'));
    }

    /**
     * View method
     *
     * @param string|null $id Refund id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $refund = $this->Refund->get($id, [
            'contain' => []
        ]);

        $this->set('refund', $refund);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $refund = $this->Refund->newEntity();
        if ($this->request->is('post')) {
            $refund = $this->Refund->patchEntity($refund, $this->request->getData());
            if ($this->Refund->save($refund)) {
                $this->Flash->success(__('The refund has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The refund could not be saved. Please, try again.'));
        }
        $this->set(compact('refund'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Refund id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $refund = $this->Refund->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $refund = $this->Refund->patchEntity($refund, $this->request->getData());
            if ($this->Refund->save($refund)) {
                $this->Flash->success(__('The refund has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The refund could not be saved. Please, try again.'));
        }
        $this->set(compact('refund'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Refund id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $refund = $this->Refund->get($id);
        if ($this->Refund->delete($refund)) {
            $this->Flash->success(__('The refund has been deleted.'));
        } else {
            $this->Flash->error(__('The refund could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
