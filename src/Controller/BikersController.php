<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Bikers Controller
 *
 *
 * @method \App\Model\Entity\Biker[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BikersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $bikers = $this->paginate($this->Bikers);

        $this->set(compact('bikers'));
    }

    /**
     * View method
     *
     * @param string|null $id Biker id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $biker = $this->Bikers->get($id, [
            'contain' => []
        ]);

        $this->set('biker', $biker);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $biker = $this->Bikers->newEntity();
        if ($this->request->is('post')) {
            $biker = $this->Bikers->patchEntity($biker, $this->request->getData());
            if ($this->Bikers->save($biker)) {
                $this->Flash->success(__('The biker has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The biker could not be saved. Please, try again.'));
        }
        $this->set(compact('biker'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Biker id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $biker = $this->Bikers->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $biker = $this->Bikers->patchEntity($biker, $this->request->getData());
            if ($this->Bikers->save($biker)) {
                $this->Flash->success(__('The biker has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The biker could not be saved. Please, try again.'));
        }
        $this->set(compact('biker'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Biker id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $biker = $this->Bikers->get($id);
        if ($this->Bikers->delete($biker)) {
            $this->Flash->success(__('The biker has been deleted.'));
        } else {
            $this->Flash->error(__('The biker could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
