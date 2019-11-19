<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Otps Controller
 *
 *
 * @method \App\Model\Entity\Otp[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class OtpsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $otps = $this->paginate($this->Otps);

        $this->set(compact('otps'));
    }

    /**
     * View method
     *
     * @param string|null $id Otp id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $otp = $this->Otps->get($id, [
            'contain' => []
        ]);

        $this->set('otp', $otp);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $otp = $this->Otps->newEntity();
        if ($this->request->is('post')) {
            $otp = $this->Otps->patchEntity($otp, $this->request->getData());
            if ($this->Otps->save($otp)) {
                $this->Flash->success(__('The otp has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The otp could not be saved. Please, try again.'));
        }
        $this->set(compact('otp'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Otp id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $otp = $this->Otps->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $otp = $this->Otps->patchEntity($otp, $this->request->getData());
            if ($this->Otps->save($otp)) {
                $this->Flash->success(__('The otp has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The otp could not be saved. Please, try again.'));
        }
        $this->set(compact('otp'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Otp id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $otp = $this->Otps->get($id);
        if ($this->Otps->delete($otp)) {
            $this->Flash->success(__('The otp has been deleted.'));
        } else {
            $this->Flash->error(__('The otp could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
