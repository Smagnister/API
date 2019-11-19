<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * FundTransfer Controller
 *
 *
 * @method \App\Model\Entity\FundTransfer[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FundTransferController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $fundTransfer = $this->paginate($this->FundTransfer);

        $this->set(compact('fundTransfer'));
    }

    /**
     * View method
     *
     * @param string|null $id Fund Transfer id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $fundTransfer = $this->FundTransfer->get($id, [
            'contain' => []
        ]);

        $this->set('fundTransfer', $fundTransfer);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $fundTransfer = $this->FundTransfer->newEntity();
        if ($this->request->is('post')) {
            $fundTransfer = $this->FundTransfer->patchEntity($fundTransfer, $this->request->getData());
            if ($this->FundTransfer->save($fundTransfer)) {
                $this->Flash->success(__('The fund transfer has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The fund transfer could not be saved. Please, try again.'));
        }
        $this->set(compact('fundTransfer'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Fund Transfer id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $fundTransfer = $this->FundTransfer->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $fundTransfer = $this->FundTransfer->patchEntity($fundTransfer, $this->request->getData());
            if ($this->FundTransfer->save($fundTransfer)) {
                $this->Flash->success(__('The fund transfer has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The fund transfer could not be saved. Please, try again.'));
        }
        $this->set(compact('fundTransfer'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Fund Transfer id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $fundTransfer = $this->FundTransfer->get($id);
        if ($this->FundTransfer->delete($fundTransfer)) {
            $this->Flash->success(__('The fund transfer has been deleted.'));
        } else {
            $this->Flash->error(__('The fund transfer could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
