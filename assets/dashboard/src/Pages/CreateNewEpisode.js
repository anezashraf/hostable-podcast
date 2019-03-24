import React from 'react'
import CreateEpisodeForm from '../Components/Forms/CreateEpisodeForm'
import { bindActionCreators } from 'redux'
import { connect } from 'react-redux'
import { saveNew } from '../Reducers/episode'
import PropTypes from "prop-types";

class CreateNewEpisode extends React.Component {
    handleSave = (title, description, audio, image) => {
      this.props.saveNew(title, description, audio, image)
    };

    render () {
      let { isNewEpisodeSaving } = this.props;

      return (
        <section>
          <CreateEpisodeForm
            isNewEpisodeSaving={isNewEpisodeSaving}
            handleSave={this.handleSave}
          />
        </section>
      )
    }
}

CreateNewEpisode.propTypes = {
    saveNew: PropTypes.func,
    isNewEpisodeSaving: PropTypes.bool,
};

const mapStateToProps = ({ episode }) => ({
  episodes: episode.episodes,
  isAudioUploading: episode.isAudioUploading,
  isImageUploading: episode.isImageUploading,
  isNewEpisodeSaving: episode.isNewEpisodeSaving
});

const mapDispatchToProps = dispatch =>
  bindActionCreators(
    {
      saveNew
    },
    dispatch
  );

export default connect(
  mapStateToProps,
  mapDispatchToProps
)(CreateNewEpisode)
