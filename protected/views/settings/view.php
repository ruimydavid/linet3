<?php


$this->beginWidget('MiniForm',array('haeder' => Yii::t("app","Update Configuration"))); 
?>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'user-form',
	'enableAjaxValidation'=>false,
)); ?>


<table>
<?php 

foreach($models as $model){
        if($model->hidden==0){
            if(strpos($model->eavType,"list(")===0){
                $modelName=  str_replace("list(", "", $model->eavType);
                $modelName=  str_replace(")", "", $modelName);
                $temp=CHtml::listData($modelName::model()->findAll(), 'id', 'name');
                 echo "<tr>";
               echo "<td>".Yii::t('app',$model->id)."</td>"; 
               echo "<td>".
                       CHtml::dropDownList('Settings['.$model->id.'][value]',$model->value,$temp).
                       "</td>"; 
               echo "</tr>";
                
            }else{
                //echo $form->errorSummary($model); 
                echo "<tr>";
               echo "<td>".Yii::t('app',$model->id)."</td>"; 
               
               echo "<td>".$form->textField($model,'['.$model->id.']value',array('size'=>30,'maxlength'=>80))."</td>"; 
               echo "</tr>";
            }
        }
	
} 
?>  
    
</table>
<?php echo CHtml::submitButton(Yii::t('app',"Save")); ?>    
<?php $this->endWidget(); ?>



    <?php 
$this->endWidget(); 
?>