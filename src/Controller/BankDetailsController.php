<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * BankDetails Controller
 *
 *
 * @method \App\Model\Entity\BankDetail[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BankDetailsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $bankDetails = $this->paginate($this->BankDetails);

        $this->set(compact('bankDetails'));
    }

    /**
     * View method
     *
     * @param string|null $id Bank Detail id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $bankDetail = $this->BankDetails->get($id, [
            'contain' => []
        ]);

        $this->set('bankDetail', $bankDetail);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $bankDetail = $this->BankDetails->newEntity();
        if ($this->request->is('post')) {
            $bankDetail = $this->BankDetails->patchEntity($bankDetail, $this->request->getData());
            if ($this->BankDetails->save($bankDetail)) {
                $this->Flash->success(__('The bank detail has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The bank detail could not be saved. Please, try again.'));
        }
        $this->set(compact('bankDetail'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Bank Detail id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $bankDetail = $this->BankDetails->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $bankDetail = $this->BankDetails->patchEntity($bankDetail, $this->request->getData());
            if ($this->BankDetails->save($bankDetail)) {
                $this->Flash->success(__('The bank detail has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The bank detail could not be saved. Please, try again.'));
        }
        $this->set(compact('bankDetail'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Bank Detail id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $bankDetail = $this->BankDetails->get($id);
        if ($this->BankDetails->delete($bankDetail)) {
            $this->Flash->success(__('The bank detail has been deleted.'));
        } else {
            $this->Flash->error(__('The bank detail could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
