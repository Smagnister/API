<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Addressbooks Controller
 *
 *
 * @method \App\Model\Entity\Addressbook[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AddressbooksController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $addressbooks = $this->paginate($this->Addressbooks);

        $this->set(compact('addressbooks'));
    }

    /**
     * View method
     *
     * @param string|null $id Addressbook id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $addressbook = $this->Addressbooks->get($id, [
            'contain' => []
        ]);

        $this->set('addressbook', $addressbook);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $addressbook = $this->Addressbooks->newEntity();
        if ($this->request->is('post')) {
            $addressbook = $this->Addressbooks->patchEntity($addressbook, $this->request->getData());
            if ($this->Addressbooks->save($addressbook)) {
                $this->Flash->success(__('The addressbook has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The addressbook could not be saved. Please, try again.'));
        }
        $this->set(compact('addressbook'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Addressbook id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $addressbook = $this->Addressbooks->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $addressbook = $this->Addressbooks->patchEntity($addressbook, $this->request->getData());
            if ($this->Addressbooks->save($addressbook)) {
                $this->Flash->success(__('The addressbook has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The addressbook could not be saved. Please, try again.'));
        }
        $this->set(compact('addressbook'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Addressbook id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $addressbook = $this->Addressbooks->get($id);
        if ($this->Addressbooks->delete($addressbook)) {
            $this->Flash->success(__('The addressbook has been deleted.'));
        } else {
            $this->Flash->error(__('The addressbook could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
