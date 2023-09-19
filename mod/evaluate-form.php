
                            <div class="card">
                                <div class="card-header">
                                    <strong>Agenda / Topic</strong>
                                </div>
                                <div class="card-body">
                                    <form id="form" data-plugin="parsley" data-option="{}">
                                        <div id="rootwizard" data-plugin="bootstrapWizard" data-option="{
            tabClass: '',
            nextSelector: '.button-next', 
            previousSelector: '.button-previous', 
            firstSelector: '.button-first', 
            lastSelector: '.button-last',
            onTabClick: function(tab, navigation, index) {
              return false;
            },
            onNext: function(tab, navigation, index) {
              var instance = $('#form').parsley();
              instance.validate();
              if(!instance.isValid()) {
                return false;
              }
            }
          }">
                                            <div class="tab-content p-3">

                                                <div class="tab-pane active" id="tab1">
                                                    <p><strong>1. Contribution / Value Creation</strong></p>

                                                    <div class="form-group">
                                                        <label>Project Deliverable</label>
                                                        <textarea name="a1" class="form-control" rows="7" required></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>People & Team</label>
                                                        <textarea name="a2" class="form-control" rows="7" required></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Knowledge Sharing</label>
                                                        <textarea name="a3" class="form-control" rows="7" required></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Sales (Opportunity, Lead, Closed, Proposal)</label>
                                                        <textarea name="a4" class="form-control" rows="7" required></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Client Satisfaction</label>
                                                        <textarea name="a5" class="form-control" rows="7" required></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label><strong>2. Lessons Learned from the experience in the last half</strong></label>
                                                        <textarea name="b" class="form-control" rows="7" required></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label><strong>3. My Suggestion and Recommendations to improv/solve Issues I have seen/experienced</strong></label>
                                                        <textarea name="c" class="form-control" rows="7" required></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label><strong>4. Future Outlook (e.g. Project and Personal/Team Development)</strong></label>
                                                        <textarea name="d" class="form-control" rows="7" required></textarea>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                </div>
                                            </div>

                                        </div>
                                    </form>
                                </div>
                            </div>