import { Component, OnInit } from '@angular/core';
import { FormGroup, FormBuilder, FormArray, FormControl, Validators } from '@angular/forms';

import { SharedDataService, UserService } from '../_services';
import { AdminModel, StandardModel } from '../_modelsIot';

@Component({
  selector: 'app-user',
  templateUrl: './user.component.html',
  styleUrls: ['./user.component.css']
})
export class UserComponent implements OnInit {

  successAdd: boolean = null;
  successSearch: boolean = null;
  accountForm: FormGroup;

  constructor(
    private fb: FormBuilder,
    private userService: UserService,
  ) { }

  ngOnInit() {
    this.accountForm = this.fb.group({
      'Username': ['', Validators.compose([Validators.required, Validators.pattern("^[a-z0-9!#$%&'*+\/=?^_`{|}~.-]+@[a-z0-9]([a-z0-9-]*[a-z0-9])?(\.[a-z0-9]([a-z0-9-]*[a-z0-9])?)*$")])],
      'Password': ['', Validators.compose([Validators.required, Validators.minLength(8)])],
      'Typology': ['', Validators.required],
    })
  }

  insertAccount(model: any, isValid: boolean) {

    this.successAdd = null;

    let objAdmin: AdminModel;
    let objStandard: StandardModel;

    objAdmin = new AdminModel();
    objStandard = new StandardModel();

    if (model.Typology == 'Standard') {


      objAdmin.Username = model.Username;
      objAdmin.Password = model.Password;
      objAdmin.Ruolo = 'Admin';
      objAdmin.Nome = '';
      objAdmin.Cognome = '';
      objAdmin.CodiceFiscale = '';

      this.userService.addAdmin(objAdmin).subscribe(
        data => {
          if (data.Value) {
            this.successAdd = true;
          }
          if (data.Value == false) {
            this.successAdd = false;
          }
        })
    }

    if (model.Typology == 'Amministratore') {

      objStandard.Username = model.Username;
      objStandard.Password = model.Password;
      objStandard.Ruolo = 'Cliente';
      objStandard.P_IVA = '';
      objStandard.Nome = '';
      objStandard.Citta = '';

      this.userService.addStandard(objStandard).subscribe(
        data => {
          if (data.Value) {
            this.successAdd = true;
          }
          if (data.Value == false) {
            this.successAdd = false;
          }
        })

    }
  }

  search() {
    this.successSearch = false;
  }

}
