<?php

class TblDomainController extends Controller
{
	public $domain_id;
	public $information_tab_enabled;
	public $contact_tab_enabled;
	public $auction_tab_enabled;

	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// page action renders "static" pages stored under 'protected/views/tblDomain/pages'
			// They can be accessed via: index.php?r=tblDomain/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'configureModel',
			'postOnly + delete, buy, offer, confirm_auction, restart_auction, delete_bid',
		);
	}

	public function filterConfigureModel(
		$chain
	) {
		$id = Yii::app(
		)->request->getParam(   
			"id"
		);
		if (
			isset(
				$id
			)
		) {
			$domain = $this->loadModel(
				$id
			);
			$this->layout = '//layouts/column2_domain';
			$this->domain_id = $domain->id;
			$this->information_tab_enabled = $domain->information_tab_enabled;
			$this->contact_tab_enabled = $domain->contact_tab_enabled;
			$this->auction_tab_enabled = $domain->auction;
		}
		$chain->run(
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		$params = array(
		);
		$id = Yii::app(
		)->request->getParam(
			"id"
		);
		if (
			isset(
				$id
			)
		) {
			$params[
				"domain"
			] = $this->loadModel(
				$id
			);
		}
		return array(
			array('allow', // allow invited user to start the auction
				'actions'=>array(
					'start_auction',
					'confirm_auction'
				),
				'roles'=>array('initiator' => $params),
			),
			array('allow',  // allow all users to perform 'status' and 'index_auctions' actions
				'actions'=>array(
					'contact',
					'index_auctions',
					'status',
					'page',
				),
				'users'=>array('*'),
			),
			array('allow',  // allow registered users to buy
					// domains, and to list domains with
					// auction starting permissions
				'actions'=>array(
					'buy',
					'prebuy',
//					'index_own',
				),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform CRUD actions
				'actions'=>array(
					'index',
					'view',
					'create',
					'update',
					'admin',
					'admin_auctions',
					'delete',
					'delete_bid',
					'prepare_offer',
					'index_contacts',
					'inspect_auction',
					'inspect_offer',
					'inspect_sale',
					'restart_auction',
					'offer',
				),
				'roles'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	protected function add_countdown_scripts(
		$client_script
	) {
		$client_script->registerScript(
			'script_1',
			'var date_now = new Date(
    "' . str_replace(
				" ",
				"T",
				Yii::app(
				)->Date->now(
				)
			) . '"
);
var seconds_now = date_now.getTime(
) / 1000;
function padded_time_component(
    value
) {
    var padded = new String(
        value
    );
    while (
        2 > padded.length
    ) {
        padded = "0" + padded;
    }
    return padded;
}
function formatted_seconds(
    seconds_of_day
) {
    var seconds = seconds_of_day % 60;
    var remaining = seconds_of_day - seconds;
    var minutes_of_day = remaining / 60;
    var minutes = minutes_of_day % 60;
    var remaining = minutes_of_day - minutes;
    var hours = remaining / 60;
    return padded_time_component(
        hours
    ) + ":" + padded_time_component(
        minutes
    ) + ":" + padded_time_component(
        seconds
    );
}
function adjust_time(
) {
    $.ajax(
        {
            url : "/site/ajaxDate",
            success : function (
                date
            ) {
                date_now = new Date(
                    date
                );
                seconds_now = date_now.getTime(
                ) / 1000;
            }
        }
    );
}
function next_day_start(
    within
) {
    var next_day = within;
    next_day.setHours(
        0
    );
    next_day.setMinutes(
        0
    );
    next_day.setSeconds(
        0
    );
    next_day = new Date(
        next_day.getTime(
        ) + 24 * 60 * 60 * 1000
    );
    return next_day;
}
var date_auction = next_day_start(
    date_now
);
var seconds_auction = date_auction.getTime(
) / 1000;
function update_remaining(
) {
    $(
        ".remaining"
    ).text(
        formatted_seconds(
            seconds_auction - seconds_now
        )
    );
}
function update_counter(
) {
    seconds_now++;
    if (
        seconds_auction <= seconds_now
    ) {
        location.reload(
        );
        return;
    }
    update_remaining(
    );
}',
			CClientScript::POS_HEAD
		);
		$client_script->registerScript(
			'script_2',
			'update_remaining(
);
window.setInterval(
    update_counter,
    1000
);
window.setInterval(
    adjust_time,
    60000
);',
			CClientScript::POS_READY
		);
	}

	/**
	 * Displays end-user actions for a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionStatus($id)
	{
		$domain = $this->loadModel(
			$id
		);
		if (
			!$domain->auction
		) {
			$this->redirect(
				array(
					'contact',
					'id' => $domain->id
				)
			);
		}

		if (
			NULL !== $domain->sold
		) {
			$location = Yii::app(
			)->createAbsoluteUrl(
				'tblDomain/index_auctions'
			);
			$client_script->registerScript(
				'script_5',
				'window.top.location.href = "' . $location . '";',
				CClientScript::POS_LOAD
			);
			$this->layout = 'none';
			$this->render(
				'redirect_top',
				array(
					'location' => $location,
				)
			);
			return;
		}
			
		$domain->process_priority_buying(
		);
		$price = $domain->get_current_price(
		);

		$client_script = Yii::app(
		)->clientScript;


		$this->add_countdown_scripts(
			$client_script
		);
		// renders the view file 'protected/views/tblDomain/status.php'
		// using the layout 'protected/views/layouts/main_domain.php'
		$this->render(
			'status',
			array(
				'model' => $domain,
				'price' => $price,
			)
		);
	}

	/**
	 * Displays the contact page
	 * @param integer $id the ID of the model to contact the site about
	 */
	public function actionContact($id)
	{
		$domain = $this->loadModel(
			$id
		);
		if (
			!$domain->contact_tab_enabled
		) {
			throw new CHttpException(
				500,
				Yii::t(
					'app',
					'Die Domain {domain} wurde derzeit noch nicht fuer die Auktion freigeschaltet.',
					array(
						'{domain}' => $domain->name,
					)
				)
			);
		}
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				Yii::app(
				)->mailer->IsSMTP(
				);
				Yii::app(
				)->mailer->From = $model->email;
				Yii::app(
				)->mailer->FromName = $model->name;
				Yii::app(
				)->mailer->AddReplyTo(
					$model->email,
					$model->name
				);
				Yii::app(
				)->mailer->AddAddress(
					Yii::app(
					)->params[
						'adminEmail'
					]
				);
				Yii::app(
				)->mailer->Subject = "Anfrage wegen Domain " . $domain->name;
				Yii::app(
				)->mailer->Body = $model->body;
				Yii::app(
				)->mailer->Send(
				);
				$contact_data = new TblContactData;
				$contact_data->domain = $domain->id;
				$contact_data->name = $model->name;
				$contact_data->email = $model->email;
				$contact_data->contacted_on = date(
					'Y-m-d H:i:s'
				);
				if (
					!$contact_data->save(
					)
				) {
					foreach (
						$contact_data->getErrors(
						) as $slot => $messages
					) {
						foreach (
							$messages as $message
						) {
							throw new CHttpException(
								500,
								"$slot: $message"
							);
						}
					}
				}
				Yii::app(
				)->user->setFlash(
					'contact',
					Yii::t(
						'app',
						'Vielen Dank fuer Ihre Mitteilung. Sie erhalten sobald wie moeglich eine Antwort.'
					)
				);
				$this->refresh();
			}
		}
		// renders the view file 'protected/views/tblDomain/status.php'
		// using the layout 'protected/views/layouts/main_domain.php'
		$this->render(
			'contact',
			array(
				'model' => $model,
				'domain' => $domain,
			)
		);
	}

	/**
	 * Prepare buying a domain.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionPrebuy($id)
	{
		$domain = $this->loadModel(
			$id
		);
		$domain->process_priority_buying(
		);
		if (
			isset(
				$_REQUEST[
					'price'
				]
			)
		) {
			throw new CHttpException(
				500,
				"ungueltige Anfrage"
			);
		}
		$this->render('buy',array(
			'model'=>$domain,
			'price'=>$domain->get_current_price(
			),
		));
	}

	/**
	 * Buy a domain.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionBuy($id)
	{
		$domain = $this->loadModel(
			$id
		);
		$domain->process_priority_buying(
		);
		if (
			isset(
				$_REQUEST[
					'price'
				]
			)
		) {
			$offered_price = intval(
				$_REQUEST[
					'price'
				]
			);
			if (
				$offered_price < $domain->get_current_price(
				)
			) {
				$this->render(
					'message',
					array(
						'model' => $domain,
						'message' => "Ein Kauf zu
diesem Preis ist leider nicht moeglich.",
					)
				);
				return;
			}
			$previous_sale = TblSale::model(
			)->findByAttributes(
				array(
					'domain' => $domain->id,
				)
			);
			if (
				null !== $previous_sale
			) {
				$this->render(
					'message',
					array(
						'model' => $domain,
						'message' => "Ein Kauf ist
leider nicht mehr moeglich, da die Domain bereits verkauft ist.",
					)
				);
				return;
			}
			$sale = new TblSale;
			$sale->domain = $domain->id;
			$sale->price = $offered_price;
			$sale->sold_at = Yii::app(
			)->Date->now(
			);
			$sale->buyer = Yii::app(
			)->user->getId(
			);
			if (
				!$sale->save(
				)
			) {
				foreach (
					$sale->getErrors(
					) as $slot => $messages
				) {
					foreach (
						$messages as $message
					) {
						throw new CHttpException(
							500,
							"$slot: $message"
						);
					}
				}
			}
			$domain->auction = 0;
			$domain->sold = $sale->id;
			if (
				!$domain->save(
				)
			) {
				foreach (
					$domain->getErrors(
					) as $slot => $messages
				) {
					foreach (
						$messages as $message
					) {
						throw new CHttpException(
							500,
							"$slot: $message"
						);
					}
				}
			}
			Yii::app(
			)->mailer->IsSMTP(
			);
			Yii::app(
			)->mailer->From = Yii::app()->params[
				'systemEmail'
			];
			Yii::app(
			)->mailer->FromName = Yii::app(
			)->name;
			Yii::app(
			)->mailer->AddReplyTo(
				Yii::app(
				)->params[
					'systemEmail'
				]
			);
			$buyer = $this->loadUserModel(
				$sale->buyer
			);
			Yii::app(
			)->mailer->AddAddress(
				 $buyer->email
			);
			Yii::app(
			)->mailer->Subject = "Domain gekauft";
			Yii::app(
			)->mailer->Body = "Sehr " . (
				(
					"Frau" == $buyer->title
				) ? "geehrte" : "geehrter"
			) . " " . $buyer->title . " " . $buyer->lastname . ",

soeben haben Sie die Domain " . $domain->name . " zum Preis von
" . $sale->price . " EUR gekauft. Sie erhalten in Kuerze eine Rechnung zu
Ihrem Kauf.";
			Yii::app(
			)->mailer->Send(
			);
			if (
				$sale->buyer != $domain->initiator
			) {
				Yii::app(
				)->mailer->ClearAllRecipients(
				);
				$initiator = $this->loadUserModel(
					$domain->initiator
				);
				Yii::app(
				)->mailer->AddAddress(
					 $initiator->email
				);
				Yii::app(
				)->mailer->Subject = "Hoeheres Gebot fuer Domain";
				Yii::app(
				)->mailer->Body = "Sehr " . (
					(
						"Frau" == $initiator->title
					) ? "geehrte" : "geehrter"
				) . " " . $initiator->title . " " . $initiator->lastname . ",

leider haben Sie die Domain " . $domain->name . " nicht erhalten, da ein
anderer Interessent bereit war, einen hoeheren Preis als den gebotenen Preis
von " . $domain->lowest_price() . " EUR zu bezahlen.";
				Yii::app(
				)->mailer->Send(
				);
			}
			$this->redirect(
				array(
					'tblSale/status',
					'id' => $sale->id
				)
			);
		}
		throw new CHttpException(
			500,
			"ungueltige Anfrage"
		);
	}

	/**
	 * Confirm the start of an auction on a domain
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionConfirm_auction($id)
	{
		$domain = $this->loadModel(
			$id
		);
		$user = $this->loadUserModel(
			$domain->initiator
		);
		$domain->auction = 1;
		$domain->auction_begin = Yii::app(
		)->Date->now(
		);
		if (
			$domain->save(
			)
		) {
			$this->redirect(
				array(
					'site/index',
					'domain' => $domain->name
				)
			);
		}
		foreach (
			$domain->getErrors(
			) as $slot => $messages
		) {
			foreach (
				$messages as $message
			) {
				throw new CHttpException(
					500,
					"$slot: $message"
				);
			}
		}
	}

	/**
	 * Start an auction on a domain
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionStart_auction($id)
	{
		$domain = $this->loadModel(
			$id
		);
		if (
			1 == $domain->auction
		) {
			throw new CHttpException(
				500,
				"Auktion laeuft bereits"
			);
		}
		$this->render('start_auction',array(
			'model'=>$domain,
		));
	}

	/**
	 * Offer a domain to a user for running an auction
	 * @param integer $id the ID of the domain model to be offered
	 * @param integer $user the ID of the user model to offer the domain to
	 */
	public function actionOffer($id, $user)
	{
		$domain = $this->loadModel(
			$id
		);

		$this->performAjaxValidation($domain);

		$user = $this->loadUserModel(
			$user
		);

		if (
			1 == $domain->auction
		) {
			throw new CHttpException(
				500,
				"Auktion bereits aktiv"
			);
		}

		if (
			null !== $domain->sold
		) {
			throw new CHttpException(
				500,
				"Domain bereits verkauft"
			);
		}

		if (
			null !== $domain->initiator
		) {
			throw new CHttpException(
				500,
				"Domain bereits einem Nutzer zugeordnet"
			);
		}

		if (
			isset(
				$_POST[
					'TblDomain'
				]
			)
		) {
			$domain->attributes = $_POST[
				'TblDomain'
			];
			$domain->initiator = $user->id;
			if (
				$domain->lowest_price(
				) != $_POST[
					"customer_price"
				]
			) {
				throw new CHttpException(
					500,
					"Fehler bei Minimalpreis: " . $_POST[
						"customer_price"
					] . " != " . $domain->lowest_price(
					)
				);
			}
			if (
				$domain->save(
				)
			) {
				$this->redirect(
					array(
						'inspect_offer',
						'id' => $domain->id
					)
				);
			}
			foreach (
				$domain->getErrors(
				) as $slot => $messages
			) {
				foreach (
					$messages as $message
				) {
					throw new CHttpException(
						500,
						"$slot: $message"
					);
				}
			}
		}

		$client_script = Yii::app(
		)->clientScript;
		$client_script->registerScript(
			'script_3',
			'var calculation_method_value = "round_down_exact_days";

function update_dependent_values(
) {
    var list_price = new Number(
        $(
            ".field_list_price"
        ).val(
        )
    );
    var customer_price = new Number(
        $(
            ".field_customer_price"
        ).val(
        )
    );
    var variation = list_price - customer_price;
    var raw_step = variation / 30;
    var price_step = raw_step - (
        raw_step % 25
    );
    if (
        1 == calculation_method_value.split(
            "round_down"
        ).length
    ) {
        price_step = price_step + 25;
    }
    var duration;
    if (
        1 == calculation_method_value.split(
            "exact_days"
        ).length
    ) {
        var raw_days = variation / price_step + 0.5;
        duration = raw_days - (
            raw_days % 1
        );
    } else {
        duration = 30;
    }
    var start_price = customer_price + price_step * duration;
    $(
        ".field_auction_price_step"
    ).val(
        price_step
    );
    $(
        ".field_auction_duration"
    ).val(
        duration
    );
    $(
        ".field_auction_start_price"
    ).val(
        start_price
    );
}

function check_calculation_method_value(
) {
    var new_value = $(
        ' . "'" . 'input[name="calculation_method"]:checked' . "'" . '
    ).val(
    );
    if (
        calculation_method_value != new_value
    ) {
        calculation_method_value = new_value;
        update_dependent_values(
        );
    }
}',
			CClientScript::POS_HEAD
		);
		$client_script->registerScript(
			'script_4',
			'$(
    ".field_list_price"
).keyup(
    update_dependent_values
);

$(
    ".field_customer_price"
).keyup(
    update_dependent_values
);

$(
    ".radio_calculation_method"
).click(
    check_calculation_method_value
);',
			CClientScript::POS_READY
		);
		$this->render(
			'configure_offer',
			array(
				'model'=>$domain,
				'user'=>$user,
			)
		);
	}

	/**
	 * Prepare a domain auction offer
	 * @param integer $id the ID of the domain model to be offered
	 */
	public function actionPrepare_offer($id)
	{
		$domain = $this->loadModel(
			$id
		);

		$dataProvider = new CActiveDataProvider(
			'User'
		);
		$this->render('offer',array(
			'dataProvider'=>$dataProvider,
			'domain' => $domain,
		));
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$model = $this->loadModel($id);
		if (
			1 == $model->auction
		) {
			$this->redirect(
				array(
					'inspect_auction',
					'id' => $model->id
				)
			);
		}
		if (
			null !== $model->sold
		) {
			$this->redirect(
				array(
					'inspect_sale',
					'id' => $model->id
				)
			);
		}
		if (
			null !== $model->initiator
		) {
			$this->redirect(
				array(
					'inspect_offer',
					'id' => $model->id
				)
			);
		}
		$this->layout = '//layouts/column2';
		$this->render('view',array(
			'model'=>$model,
		));
	}

	/**
	 * Display offer status of a particular domain
	 * @param integer $id the ID of the domain to be inspected
	 */
	public function actionInspect_offer($id)
	{
		$model = $this->loadModel(
			$id
		);
		$user = $this->loadUserModel(
			$model->initiator
		);
		$this->render(
			'inspect_offer',
			array(
				'model'=>$model,
				'user'=>$user,
			)
		);
	}

	/**
	 * Display sale status of a particular domain
	 * @param integer $id the ID of the domain to be inspected
	 */
	public function actionInspect_sale($id)
	{
		$model = $this->loadModel(
			$id
		);
		$initiator = $this->loadUserModel(
			$model->initiator
		);
		$sale = $this->loadSaleModel(
			$model->sold
		);
		$buyer = $this->loadUserModel(
			$sale->buyer
		);
		$this->layout = '//layouts/column2';
		$this->render(
			'inspect_sale',
			array(
				'model'=>$model,
				'initiator'=>$initiator,
				'sale'=>$sale,
				'buyer'=>$buyer,
			)
		);
	}

	/**
	 * Restart auction.
	 * @param integer $id the ID of the domain to be modified
	 */
	public function actionRestart_auction($id)
	{
		$model = $this->loadModel(
			$id
		);
		$sale = $this->loadSaleModel(
			$model->sold
		);
		if (
			$model->initiator == $sale->buyer
		) {
			throw new CHttpException(
				500,
				"Domain bereits vom Erstinteressenten gekauft"
			);
		}
		$sale->delete(
		);
		$model->sold = null;
		$model->auction = 1;
		$model->auction_begin = Yii::app(
		)->Date->now(
		);
		if (
			!$model->save(
			)
		) {
			foreach (
				$model->getErrors(
				) as $slot => $messages
			) {
				foreach (
					$messages as $message
				) {
					throw new CHttpException(
						500,
						"$slot: $message"
					);
				}
			}
		}
		$this->redirect(
			array(
				'inspect_auction',
				'id' => $model->id
			)
		);
	}

	/**
	 * Delete auction bid. Auction initiator gets the domain at the
	 * lowest price.
	 * @param integer $id the ID of the domain to be modified
	 */
	public function actionDelete_bid($id)
	{
		$model = $this->loadModel(
			$id
		);
		$old_sale = $this->loadSaleModel(
			$model->sold
		);
		if (
			$model->initiator == $old_sale->buyer
		) {
			throw new CHttpException(
				500,
				"Domain bereits vom Erstinteressenten gekauft"
			);
		}
		$old_sale->delete(
		);
		$new_sale = new TblSale;
		$new_sale->domain = $model->id;
		$new_sale->price = $model->lowest_price(
		);
		$new_sale->sold_at = Yii::app(
		)->Date->now(
		);
		$new_sale->buyer = $model->initiator;
		if (
			!$new_sale->save(
			)
		) {
			foreach (
				$new_sale->getErrors(
				) as $slot => $messages
			) {
				foreach (
					$messages as $message
				) {
					throw new CHttpException(
						500,
						"$slot: $message"
					);
				}
			}
		}
		$model->sold = $new_sale->id;
		if (
			!$model->save(
			)
		) {
			foreach (
				$model->getErrors(
				) as $slot => $messages
			) {
				foreach (
					$messages as $message
				) {
					throw new CHttpException(
						500,
						"$slot: $message"
					);
				}
			}
		}
		$this->redirect(
			array(
				'inspect_sale',
				'id' => $model->id
			)
		);
	}

	/**
	 * Display auction status of a particular domain
	 * @param integer $id the ID of the domain to be inspected
	 */
	public function actionInspect_auction($id)
	{
		$model = $this->loadModel(
			$id
		);
		$user = $this->loadUserModel(
			$model->initiator
		);
		$this->render(
			'inspect_auction',
			array(
				'model'=>$model,
				'user'=>$user,
			)
		);
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new TblDomain;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['TblDomain']))
		{
			$model->attributes=$_POST['TblDomain'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->layout = '//layouts/column2';
		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['TblDomain']))
		{
			$model->attributes=$_POST['TblDomain'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->layout = '//layouts/column2';
		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all contact data models with interest in the domain
	 */
	public function actionIndex_contacts($id)
	{
		$model=$this->loadModel($id);
		$contact_data=new TblContactData('search');
		$contact_data->unsetAttributes();  // clear any default values
		if(isset($_GET['TblContactData']))
			$contact_data->attributes=$_GET['TblContactData'];
		$contact_data->domain = $id;

		$this->layout = '//layouts/column2';
		$this->render('index_contacts',array(
			'model'=>$model,
			'contact_data'=>$contact_data,
		));
	}

	/**
	 * Lists all models with open auctions.
	 */
	public function actionIndex_auctions()
	{
		$model=new TblDomain('search');
		$model->unsetAttributes();  // clear any default values
		$model->auction = 1;
		$dataProvider = $model->search(
		);
		$client_script = Yii::app(
		)->clientScript;
		$this->add_countdown_scripts(
			$client_script
		);
		$this->render('index_auctions',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('TblDomain');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all auction models.
	 */
	public function actionAdmin_auctions()
	{
		$model=new TblDomain('search');
		$model->unsetAttributes();  // clear any default values
		$model->auction = 1;
		if(isset($_GET['TblDomain']))
			$model->attributes=$_GET['TblDomain'];

		$this->render('admin_auctions',array(
			'model'=>$model,
		));
	}

	/**
	 * Lists all models where the logged user has auction starting privilege
	 */
	public function actionIndex_own()
	{
		$model = new TblDomain(
			'search'
		);
		$model->unsetAttributes(
		);
		$model->initiator = Yii::app(
		)->user->id;
		$dataProvider = $model->search(
		);
		$this->render(
			'index_own',
			array(
				'dataProvider' => $dataProvider,
			)
		);
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new TblDomain('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['TblDomain']))
			$model->attributes=$_GET['TblDomain'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return TblDomain the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=TblDomain::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(
				404,
				Yii::t(
					'app',
					'Seite nicht gefunden.'
				)
			);
		return $model;
	}

	/**
	 * Returns the sale model based on the primary key
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return TblSale the loaded model
	 * @throws CHttpException
	 */
	public function loadSaleModel($id)
	{
		$model=TblSale::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(
				404,
				Yii::t(
					'app',
					'Seite nicht gefunden.'
				)
			);
		return $model;
	}

	/**
	 * Returns the user model based on the primary key
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return User the loaded model
	 * @throws CHttpException
	 */
	public function loadUserModel($id)
	{
		$model=User::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(
				404,
				Yii::t(
					'app',
					'Seite nicht gefunden.'
				)
			);
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param TblDomain $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='tbl-domain-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	/**
	 * @inheritdoc
	 */
	public function getActionParams()
	{
		return $_REQUEST;
	}
}
