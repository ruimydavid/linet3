<?php
/***********************************************************************************
 * The contents of this file are subject to the Mozilla Public License Version 2.0
 * ("License"); You may not use this file except in compliance with the Mozilla Public License Version 2.0
 * The Original Code is:  Linet 3.0 Open Source
 * The Initial Developer of the Original Code is Adam Ben Hur.
 * All portions are Copyright (C) Adam Ben Hur.
 * All Rights Reserved.
 ************************************************************************************/
/**
 * This is the model class for table "accType".
 *
 * The followings are the available columns in table 'accType':
 * @property integer $id
 * @property string $name
 * @property string $desc
 * @property string $openformat
 */
class Acctype extends CActiveRecord{
        const table='{{accType}}';
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Acctype the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName(){
		return  self::table;
	}
        public function getName($id){
            $model=  Acctype::model()->findByPk($id);
            if($model==NULL){
                return 'ERROR';
            }else {
                return Yii::t('app',$model->desc);
            }
            
        }
        
        public function switchType($old,$new){
            
            $criteria=new CDbCriteria;
            $criteria->condition="type = :type";
            $criteria->params=array(
                ':type' => $old,
              );

            $accounts= Accounts::model()->findAll($criteria);
            foreach($accounts as $account){
                $account->type=$new;
                $account->save();
            }
            
        }
        
        
        public function getTotal($from_date,$to_date){
            $sum=0;
            $criteria=new CDbCriteria;
            $criteria->condition="type = :type";
            $criteria->params=array(
                ':type' => $this->id,
              );

            $accounts= Accounts::model()->findAll($criteria);
            foreach($accounts as $account){
                    $sum+=$account->getTotal($from_date,$to_date); 
            }
            return $sum;
        }
        
        
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, desc, openformat', 'required'),
			array('name, desc', 'length', 'max'=>40),
			array('openformat', 'length', 'max'=>5),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, desc, openformat', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
                    
		);
	}
	
	public function getType($name){
		$model=Acctype::model()->find('name=:name',array(':name'=>$name));
		//print_r($this);
		//$post=Post::model()->find('postID=:postID', array(':postID'=>10));
		return $model->id;
	}//*/
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
                    'id'=>Yii::t('labels','ID'),
                    'name'=>Yii::t('labels','Name'),
                    'desc'=>Yii::t('labels','Description'),
                    'openformat'=>Yii::t('labels','Open Format'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('desc',$this->desc,true);
		$criteria->compare('openformat',$this->openformat,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}